<?php






// use GuzzleHttp\Client;
// use Illuminate\Http\UploadedFile;



/**
 * Quick Getter
 *  Read MORE FROM https://github.com/Mombuyish/Laravel-Imgur

    You can use pretty methods to get what you want informations.

    $image = new ImgurFileManager();
    $uploadManager = $image->upload($file);

        // Pass in Content
        -------------------
        You can either pass Image-File ( $request['image'] ) to   upload
           or $image = $uploadManager->upload( file_get_contents($request['image']->getRealPath()) );
                which could also be

                        // Resize be upload
                        -------------------
                        $imgThumb = Image::make($image->getRealPath())->resize(200, 150, function ($constraint) {
                        $constraint->aspectRatio();
                        })->encode('jpg', 80);

                        $image = $uploadManager->upload( file_get_contents($imgThumb) );



                        // get on size based    ['s', 'b', 't', 'm', 'l', 'h'] //       (t) small,    (b) big,   (t) too small,  (m) medium small,  (l) large small, (h) huge small
                        -------------------
                        $uploadManager->size($image->link(), 's')





    // Useful Method
    -------------------
    // Get Image image link.
    $uploadManager->link(); //"https://i.Image.com/XN9m1nW.jpg"

    // Get Image image file size.
    $uploadManager->fileszie(); //43180

    // Get Image image file type.
    $uploadManager->type(); //"image/jpeg"

    // Get Image image width.
    $uploadManager->width(); //480

    // Get Image image height.
    $uploadManager->height(); //640

    // Or you can get usual data.
    $uploadManager->usual();
    //[
        //  'link' => "https://i.Image.com/XN9m1nW.jpg",
        //  'filesize' => 43180,
        //  'type' => "image/jpeg",
        //  'width' => 480,
        //  'height' => 640,
    //]
 *
 *
 *
 *
 *
 *
        Upload Response is
        {
        "response":{"data":{"id":"xsSDszS"
            "title":null
            "description":null
            "datetime":1517765309
            "type":"image/png"
            "animated":false
            "width":1200
            "height":1200
            "size":20894
            "views":0
            "bandwidth":0
            "vote":null
            "favorite":false
            "nsfw":null
            "section":null
            "account_url":null
            "account_id":0
            "is_ad":false
            "in_most_viral":false
            "has_sound":false
            "tags":[]
            "ad_type":0
            "ad_url":""
            "in_gallery":false
            "deletehash":"2GlmUyw3i4BhADs"
            "name":""
            "link":"https://i.Image.com/xsSDszS.png"}
            "success":true
            "status":200}
        }
 *
 *
 *
 *
 */





class ImgurFileManager{
    protected $url = 'https://api.Imgur.com/3/image';
    protected $headers = [];
    protected $params = [];
    static protected $size = ['s', 'b', 't', 'm', 'l', 'h'];
    public $response;
    const VERSION = 'v3';
    private $client_id;
    private $client_secret;
    private $image;
    public function __construct(){
        $this->client_id = Config1::IMGUR_CLIENT_ID;
        $this->client_secret = Config1::IMGUR_CLIENT_SECRET;
        return $this;
        //Console1::popupAny([$this->client_id, $this->client_secret]);
    }



    public function testUpload($imgLink = 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Apple_logo_black.svg/1200px-Apple_logo_black.svg.png'){ return $this->upload($imgLink); }


    /**
     * @return string
     */
    public function __toString(){ return $this->response->data->link; }

    public static function instance(){ return new self(); }

    public function setSize($size){ self::$size = $size;  return $this;  }

    /**
     * Check API version.
     *
     * @return string
     */
    public static function version(){ return self::VERSION; }

    /**
     * If concrete instance UploadedFile, it should transform base64, either return url.
     *
     * @param $imageUrlOrImagePath
     * @return string
     */
    private function fileType($imageUrlOrImagePath){
        if(is_string($imageUrlOrImagePath) &&  String1::startsWith( strtolower($imageUrlOrImagePath), 'http' ) ) return $imageUrlOrImagePath;
        else{
            $path = (is_array($imageUrlOrImagePath)) ?  $imageUrlOrImagePath['tmp_name']: $imageUrlOrImagePath;
            return base64_encode(file_get_contents($path));
        }
    }

    /**
     * Set headers.
     *
     * @param $headers
     * @return $this
     */
    public function setHeaders($headers){
        $this->headers = $headers;
        return $this;
    }

    /**
     * If does not set headers, using default header, either return headers.
     *
     * @return array
     */
    private function getHeaders(){
        if (empty($this->headers)) {
            return [
                'headers' => [ 
                    'authorization' => 'Client-ID ' . $this->client_id,
                    //'content-type' => 'application/x-www-form-urlencoded',
                ]
            ];
        }
        return $this->headers;
    }


    /**
     * Set form params.
     *
     * @param $params
     * @return $this
     */
    public function setFormParams($params){
        $this->params = $params;
        return $this;
    }

    /**
     * If does not set form, using default form, either return form.
     *
     * @return array
     */
    private function getFormParams(){
        if (empty($this->params)) return [ 'form_params' => [ 'image' => $this->image ] ];
        return $this->params;
    }

    private function setImage($image){
        $this->image = $image;
        return $this;
    }

    /**
     * Main entrance point.
     *
     * @param $image
     * @return $this
     */
    public function upload($imageUrlOrImagePath){
        //try{
            $this->setImage($this->fileType($imageUrlOrImagePath));
            $response = Url1::cURL_fromGuzzle( $this->url, $this->getFormParams(), $this->getHeaders() );
            $this->setResponse(json_decode($response));
            return $this;
        //}catch (Exception $e){

        //}
        //return null;
    }



    /**
     * get uploaded image link.
     *
     * @return mixed
     */
    public function link(){ return isset($this->response)? $this->response->data->link: null;  }

    /**
     * get uploaded image size.
     *
     * @return mixed
     */
    public function filesize(){  return isset($this->response)? $this->response->data->size: null; }

    /**
     * get uploaded image type.
     *
     * @return mixed
     */
    public function type(){  return isset($this->response)? $this->response->data->type: null; }

    /**
     * get uploaded image width.
     *
     * @return mixed
     */
    public function width(){  return isset($this->response)? $this->response->data->width: null; }

    /**
     * get uploaded image height.
     *
     * @return mixed
     */
    public function height(){  return isset($this->response)? $this->response->data->height: null; }

    /**
     * get uploaded image usual parameters.
     *
     * @return mixed
     */
    public function usual(){
        return isset($this->response)?
         [
            'link' => $this->link(),
            'filesize' => $this->filesize(),
            'type' => $this->type(),
            'width' => $this->width(),
            'height' => $this->height(),
        ]: null;
    }

    /**
     * delete link.
     *
     * @return mixed
     */
    public function deleteLink(){   return isset($this->response)? 'https://i.imgur.com/delete/'.$this->response->data->deletehash: null; }



    private function setResponse($response){
        $this->response = $response;
        return $this;
    }


    /**
     * Delete Up
     * @param null $hashCode
     * @return null|string
     */
    public function makeDeleteLink($hashCode = null){ return $hashCode?  'https://i.imgur.com/delete/'.$hashCode: null; }

    /**
     * Imgur image size.
     *  s = Small Square (90×90) as seen in the example above
        b = Big Square (160×160)
        t = Small Thumbnail (160×160)
        m = Medium Thumbnail (320×320)
        l = Large Thumbnail (640×640) as seen in the example above
        h = Huge Thumbnail (1024×1024)
     * @param $url
     * @param $size
     * @return string
     */
    static public function makeSize($url = null, $size = 'm'){
        if(!String1::contains('imgur.com', $url)  || !$size) return $url;
        $extension = FileManager1::getExtension($url);
        return String1::replaceEnd($url, ".$extension", "$size.$extension");


        //if (!in_array($size, self::$size)) throw new InvalidArgumentException("Imgur does not support ' $size ' type." );
        //        $delimiter = 'https://i.imgur.com/';
        //        $image = explode('.', explode($delimiter, $url)[1]);
        //        return $delimiter . $image[0] . $size . '.' . $image[1];
    }

    /**
     * medium size for thumbnail
     * Imgur image size.
     * @param $url
     * @return string
     */
    static public function makeSizeThumb($url = null){ return static::makeSize($url, 'm'); }

    /**
     * Imgur image size.
     * @param $url
     * @return string
     */
    static public function makeSizeSmall($url = null){ return static::makeSize($url, 'l'); }


}
