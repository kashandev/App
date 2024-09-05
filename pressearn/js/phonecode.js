/**
 * @author jaskaranjit
 * @publisher SinghCoders.com
 *  phonecode is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *   
 *   phonecode is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *   
 *   You should have received a copy of the GNU General Public License
 *   along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * properties
 * - setClass (String) -> Class of input field
 * - bgColor (String) -> background of setClass
 * - fontColor(String) -> font color of setClass
 * - prefix (Boolean) -> show prefix ture/false
 * 
 */
(function($){
	$.fn.phonecode = function(options){
            $defaults={
		setClass: null,
		bgColor: 'white',
                fontColor: 'black',
                prefix: true
		}
		$opt=$.extend(true,$defaults, options);
		$('.'+$opt.setClass).prop('disabled',true);
		$ele =$(this);
                setOptions($ele);
                //check prefix should be boolean
                if($opt.prefix===true | $opt.prefix===false){
                    $opt.prefix =$opt.prefix
                }
                else{
                    $.error("value of 'prefix' cannot be '"+$opt.prefix+"'");
                    $opt.prefix =$defaults.prefix;
                    
                }
	$ele.on('change',function(){
		$selected=$(this).val();
		if($opt.setClass!=null){
			
			$.ajax({
            type: "GET",
            url: "http://jaskaranjitsingh.com/geosingh/country="+$selected,
            datatype: "json",
            crossDomain : true,
            success:function(data){
            json=$.parseJSON(data);
            $.each(json, function(index, val) {
                if($opt.prefix===true){
                $('.'+$opt.setClass).val("+"+val.pcode);
                }
                else{
                $('.'+$opt.setClass).val(val.pcode); 
                }
			 
                $('.'+$opt.setClass).css({'background':'url("_images/'+val.ccode+'.png")',
			 							'background-repeat':'no-repeat',
			 							'padding-left':'50px',
			 							'background-color':$opt.bgColor,
			 							'background-position':'5px 5px',
                                                                                'color':$opt.fontColor
			 							
			 							});
		$('.'+$opt.setClass).prop('disabled',false);
			 
            });
            	
            }
		
	});
		}
	});
	}
	
}(jQuery));

function setOptions($el){
	$.ajax({
            type: "GET",
            url: "http://jaskaranjitsingh.com/geosingh/country",
            datatype: "json",
            crossDomain : true,
            success:function(data){
            json=$.parseJSON(data);
            	$.each(json, function(arrayID,group) {
    				$($el).append('<option>'+group.name+'</option>'); 
     });
            }
		
	});
}
