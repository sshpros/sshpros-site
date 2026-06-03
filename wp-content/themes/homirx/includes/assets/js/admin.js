(function($) {
"use strict";
   $(window).load(function() {
      function gavias_setup_metatabs() {
         //Breacrumb js
         $('.breadcrumb_setting').hide();
         if($('#homirx_breadcrumb_layout').val() == 'page_options'){
             $('.breadcrumb_setting').show();
         }
         $('#homirx_breadcrumb_layout').on('change', function(e){
             if($(this).val() == 'page_options'){
                 $('.breadcrumb_setting').show();
             }else{
                 $('.breadcrumb_setting').hide();
             }
         })
      }
      gavias_setup_metatabs(); 
   })

   $(document).ready(function(){
      if($('#floor_plan_index').length){
         var index = $('#floor_plan_index').val();
         $(document).delegate('#addFloorPlan', 'click', function(e){
            e.preventDefault();
            var html = '<div class="floor_plan-field-item floor-plan-item" id="floorPlanID-' + index + '">\
                  <div class="field-content"> \
                     <div class="directorist-form-group field-title">\
                        <label>Title</label>\
                        <input type="text" name="lt_floor_plan[' + index + '][title]" class="directorist-form-element directory_field" value="" placeholder="First Floor" required>\
                     </div>\
                     <div class="directorist-form-group field-image">\
                        <label>Image Url</label>\
                        <input type="text" name="lt_floor_plan[' + index + '][image]" class="directorist-form-element directory_field" value="" placeholder="Add Image Url" required>\
                     </div>\
                     <div class="directorist-form-group field-desc">\
                        <label>Description</label>\
                        <textarea name="lt_floor_plan[' + index + '][desc]" class="directorist-form-element directory_field" placeholder="Add The Description"></textarea>\
                     </div>\
                  </div>\
                  <div class="directorist-form-group floor-plan-fields__action">\
                     <a href="#" data-item="floorPlanID-' + index + '" class="floor-plan-fields__remove dashicons dashicons-trash" title="Remove this item"></a>\
                  </div>\
               </div>';
            $(this).parents('.directorist-form-floor-plan-field').find('#floor_plan_sortable_container').append(html);
            index++;
            $('#floor_plan_index').val(index);
         });

         $(document).delegate('.floor-plan-fields__remove', 'click', function(e){
            e.preventDefault();
            var id = $(this).attr('data-item');
            $(this).parents('.floor-plan-item#' + id).remove();
         });
      }
   })

})(jQuery);