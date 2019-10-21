
    <script src="<?= shared_asset('prettyprint-json/prettyprint.min.js') ?>"> </script>



    <script>
        // Sample JSON
        var tbl = prettyPrint( {

            "name": "json.human",
            "description": "Convert\n JSON to human readable\r HTML",
            "author": "Mariano Guerra <mariano@marianoguerra.org>",
            "tags": ["DOM", "HTML", "JSON", "Pretty Print"],
            "version": "0.1.0",
            "main": "json.human.js",
            "license" : "MIT",
            "dependencies": {
            "crel": "1.0.0"
        }} );
        
        
        
        //Popup Use As 
        swal('hello', tbl);
        
        // Or, on Ducument Page
        //document.body.insertBefore( tbl, document.body.firstChild );
    </script>