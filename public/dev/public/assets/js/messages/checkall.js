$(document).ready(function(){
   
   $(':checkbox.selectall').on('click', function(){
        $(':checkbox[name=' + $(this).data('checkbox-name') + ']').prop("checked", $(this).prop("checked"));
    });
   // Individual checkboxes
    $(':checkbox.checkme').on('click', function(){ // 1

        var _this = $(this); // 2
        var _selectall = _this.prop("checked"); //3

        if ( _selectall ) { // 4
            // 5
            $( ':checkbox[name=' + _this.attr('name') + ']' ).each(function(i){
                // 6
                _selectall = $(this).prop("checked");
                return _selectall; // 7
            });

        }
        
        // 8
        $(':checkbox[name=' + $(this).data('select-all') + ']').prop("checked", _selectall);
    });
    
});