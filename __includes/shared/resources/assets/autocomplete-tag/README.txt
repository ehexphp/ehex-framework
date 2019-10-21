 <input id="ms1" style="width:400px;" type="text" name="ms1"/>






{{--<script src="{{ shared_asset() }}/autocomplete-tag/helper/modernizr.min.js"></script>--}}
    {{--<script src="{{ shared_asset() }}/jquery/js/jquery2.1.3.min.js"></script>--}}
    <link rel="stylesheet" href="{{ shared_asset() }}/autocomplete-tag/helper/normalize.min.css"/>
    <link rel="stylesheet" href="{{ shared_asset() }}/autocomplete-tag/style.css"/>
    <script src="{{ shared_asset() }}/autocomplete-tag/script.js"></script>
    <script>
        $(document).ready(function() {
            var jsonData = [];
            var fruits = 'Samson, iyanu,Apple,Orange,Banana,Strawberry'.split(',');
            for(var i=0;i<fruits.length;i++) jsonData.push({id:i,name:fruits[i]});
            var ms1 = $('#ms1').tagSuggest({
                data: jsonData,
                sortOrder: 'name',
                maxDropHeight: 200,
                name: 'ms1'
            });
        });
    </script>