# Ehex Shards_Dashboard template
This is Ehex Default Dashboard template. 
* It is Neat and Flexible
* Powered by Popular Ui Framework, Bootstrap 4.0.




## Sidebar
 Template default sidebar content is generated automatically when a model that implemented ```Model1ActionInterface``` is added to your project.
 But This could also be customized to suit a certain page requirement or disable to allow more space for other your page.
 
#### Override Sidebar
To Replace Sidebar content, add ```page_sidebar``` section to your page.
```php
    @section('page_sidebar')
        // new sidebar content here...
    @endsection
```


#### Disable Sidebar
To disable sidebar,  add ```page_disable_sidebar``` parameter when extending template. i.e ```@extends('layouts.shards_dashboard.template', ['page_disable_sidebar'=>'true'])```



## Footer
This is the last section of a page.

#### Override Footer
To Replace Default Footer content, add ```page_footer``` section to your page.
```php
    @section('page_footer')
        // new content here...
    @endsection
```



## Contributor
https://designrevision.com/downloads/shards-dashboard-lite/






## popular widget
This is a popular grid widget
<img src="" />
```html
    <div class="row">
        <?php $cursor = Portfolio::query()->paginate(24); ?>
        @foreach($cursor as $row)
            <?php $row = Portfolio::findOrInit($row); ?>
            <div class="col-xl-2 col-lg-3 col-md-6 col-xs-12 mb-4" onclick="Url1.redirect('{{ url("/portfolio/".$row->id) }}')">
                <div class="card card-small card-post card-post--1">
                    <div class="card-post__image" style="background-image: url('{{ $row->feature_image_url }}');">
                        <a href="#" class="card-post__category badge badge-pill badge-dark">{{ $row->category }}</a>
                        <div class="card-post__author d-flex"> <a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('{{ $userInfo->getAvatar() }}');">By {{ User::find($row->user_id, 'id', '', ['full_name'])['full_name'] or 'Unknown' }}</a> </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"  style="height:50px;overflow: hidden"> <a class="text-fiord-blue" href="#">{{ $row->name }}</a> </h5>
                        <p class="card-text d-inline-block mb-3" style="height:100px;overflow: hidden">{!! String1::getSomeText(Html1::removeTag(String1::getSomeText($row->description, 500, '')), 125) !!}</p>
                        <div> <a href="{{ url("/portfolio/$row->id/edit/") }}"><i class="fa fa-edit" aria-hidden="true"></i></a> |
                            @if($row->is_active) <a href="{{ url("/portfolio/".$row->id) }}">Read More</a> @else <span class="text-muted">Not Active</span> @endif
                            <span class="text-muted pull-right">{!! DateManager1::diffForHumans($row->created_at) !!}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    
        <div class="col-md-12" style="margin-top:30px;"><div class="pull-right"><?= $cursor ?></div></div>
    </div>
```