
<div class="row">

    <div class="form-group col-sm-3">
        <label>Level1 <span class="text-danger">*</span></label>
        <select name="l1headId" class="form-control selectpicker" data-container="body"
                data-live-search="true" required>
            <option value="">Choose Head</option>
            @isset($data['l1Head'])
                @foreach($data['l1Head'] as $l1Head)
                    <option value="{{$l1Head->id}}"
                    >{{$l1Head->level_head}}</option>
                @endforeach
            @endisset
        </select>

    </div>
    <div class="form-group col-sm-3 l2-section" style="display: none">
        <label>Level2 <span class="text-danger">*</span></label>
        <select class="form-control inpL2" name="l2headId" id="l2Dropdown">
            <option value="">Choose Head</option>
        </select>

    </div>
    <div class="form-group col-sm-2 l3-section" style="display: none">
        <label>Level3 <span class="text-danger">*</span></label>
        <select class="form-control inpL3" name="l3headId" id="l3Dropdown"  >
            <option value="">Choose Head</option>
        </select>

    </div>
    <div class="form-group col-sm-2 l4-section" style="display: none">
        <label>Level4 <span class="text-danger">*</span></label>
        <select class="form-control inpL4" name="l4headId" id="l4Dropdown"  >
            <option value="">Choose Head</option>
        </select>

    </div>
    <div class="form-group col-sm-2 l5-section" style="display: none">
        <label>Level5 <span class="text-danger">*</span></label>
        <select class="form-control inpL5" name="l5headId" id="l5Dropdown"  >
            <option value="">Choose Head</option>
        </select>

    </div>

</div>


<script type='text/javascript'>
    $(document).ready(function (){

        //get l2 head on the bas of l1
        $('select[name=l1headId]').on('change', function() {
            var l1headId=$(this).val();
            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{url("get-l2heads-with-params")}}',
                data: {l1headId: l1headId},
                async: false,
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        $(".inpL2").prop('required',true);

                        $(".l2-section").css("display", "block");
                        var html = '<option value="">Choose Head</option>';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<option value="' + data[i].id + '">' + data[i].level_two_head + '</option>';
                        }
                    }else{
                        $(".l2-section").css("display", "none");
                    }

                    $('#l2Dropdown').html(html);
                },

                error: function() {

                    alert('Could not get Data from Database');

                }

            });



        });
        //get l3 head on the bas of l2
        $('select[name=l2headId]').on('change', function() {
            var l2headId=$(this).val();

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{url("get-l3heads-with-params")}}',
                data: {l2headId:l2headId},
                async: false,
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {

                        $(".inpL3").prop('required',true);
                        $(".l3-section").css("display", "block");
                        var html = '<option value="">Choose Head</option>';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<option value="' + data[i].id + '">' + data[i].level_three_head + '</option>';
                        }
                    }else{
                        $(".l3-section").css("display", "none");
                    }
                    $('#l3Dropdown').html(html);
                },

                error: function() {

                    alert('Could not get Data from Database');

                }

            });



        });
        //get l4 head on the bas of l3
        $('select[name=l3headId]').on('change', function() {
            var l3headId=$(this).val();

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{url("get-l4heads-with-params")}}',
                data: {l3headId:l3headId},
                async: false,
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        $(".inpL4").prop('required',true);
                        $(".l4-section").css("display", "block");
                        var html = '<option value="">Choose Head</option>';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<option value="' + data[i].id + '">' + data[i].level_four_head + '</option>';
                        }
                    }
                    else{
                        $(".l4-section").css("display", "none");
                    }

                    $('#l4Dropdown').html(html);
                },

                error: function() {

                    alert('Could not get Data from Database');

                }

            });



        });
        //get l5 head on the bas of l4
        $('select[name=l4headId]').on('change', function() {
            var l4headId=$(this).val();

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{url("get-l5heads-with-params")}}',
                data: {l4headId:l4headId},
                async: false,
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        $(".inpL5").prop('required',true);
                        $(".l5-section").css("display", "block");
                        var html = '<option value="">Choose Head</option>';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<option value="' + data[i].id + '">' + data[i].level_five_head + '</option>';
                        }
                    }else{
                        $(".l5-section").css("display", "none");
                    }

                    $('#l5Dropdown').html(html);
                },
                error: function() {
                    alert('Could not get Data from Database');
                }

            });



        });

    })
</script>
