var UITreeview = function() {
	"use strict";
	//function to initiate jquery.dynatree
	var runTreeView = function(store_id,tree_url) {


		//Default Tree
		$('#tree').jstree({
			"core" : {
				"themes" : {
					"responsive" : false
				}
			},
			"types" : {
				"default" : {
					"icon" : "fa fa-folder text-yellow fa-lg"
				},
				"file" : {
					"icon" : "fa fa-file text-azure fa-lg"
				}
			},
			"plugins" : ["dnd","types"]
		});

		//Checkbox
		$('#tree_2').jstree({
			'plugins' : ["wholerow", "checkbox", "types"],
			'core' : {
				"themes" : {
					"responsive" : false
				},
			
			},
			"types" : {
				"default" : {
					"icon" : "fa fa-folder text-red fa-lg"
				},
				"file" : {
					"icon" : "fa fa-file text-red fa-lg"
				}
			}
		});
		
		//Checkbox
		$('#tree_2_master').jstree({
			'plugins' : ["wholerow", "checkbox", "types"],
			'core' : {
				"themes" : {
					"responsive" : false
				},
			
			},
			"types" : {
				"default" : {
					"icon" : "fa fa-folder text-red fa-lg"
				},
				"file" : {
					"icon" : "fa fa-file text-red fa-lg"
				}
			},
			 
		});		
 $("#tree_3").jstree();		
		// Drag & drop
		// $("#tree_3").jstree({
		// 	"core" : {
		// 		"themes" : {
		// 			"responsive" : false
		// 		},
		// 		// so that create works
		// 		"check_callback" : true,
				
		// 	},
		// 	"types" : {
		// 		"default" : {
		// 			"icon" : "fa fa-folder text-red fa-lg"
		// 		},
		// 		"file" : {
		// 			"icon" : "fa fa-file text-red fa-lg"
		// 		}
		// 	},
		// 	"state" : {
		// 		"key" : "demo2"
		// 	},
		// 	"dnd" : {
		// 				"drop_finish" : function () { 
		// 					alert("DROP"); 
		// 				},
		// 				"drag_check" : function (data) {
		// 					if(data.r.attr("id") == "phtml_1") {
		// 						return false;
		// 					}
		// 					return { 
		// 						after : false, 
		// 						before : false, 
		// 						inside : true 
		// 					};
		// 				},
		// 				"drag_finish" : function (data) { 
		// 					alert("DRAG OK"); 
		// 				}
		// 			},			
		// 	"plugins" : ["dnd", "types"]
		// }).bind("move_node.jstree", function (e, data) {
		// 	console.log(data);
		// 	var parent_id = data.parent;
		// 	if(parent_id == "#"){
		// 		parent_id = 0;	
		// 	}
		// 	var category_id = data.node.id;
		// 	var position = data.position;

		// 	var l = "/backend/web/index.php/build_content/category/update_parent?parent_id=" + parent_id + "&category_id=" + category_id + "&position=" + position;
		// 	$.get(l,function(data){
		// 		document.location.href = "/backend/web/index.php/build_content/category/main?store_id=" + store_id + "&category_id=" + category_id + "&edit_mode=Y";
		// 	});

  //       });
		
		
		$("#tree_3_master").jstree({
			"core" : {
				"themes" : {
					"responsive" : false
				},
				// so that create works
				"check_callback" : true,
				
			},
			"types" : {
				"default" : {
					"icon" : "fa fa-folder text-red fa-lg"
				},
				"file" : {
					"icon" : "fa fa-file text-red fa-lg"
				}
			},
			"state" : {
				"key" : "demo2"
			},
			"dnd" : {
						"drop_finish" : function () { 
							alert("DROP"); 
						},
						"drag_check" : function (data) {
							if(data.r.attr("id") == "phtml_1") {
								return false;
							}
							return { 
								after : false, 
								before : false, 
								inside : true 
							};
						},
						"drag_finish" : function (data) { 
							alert("DRAG OK"); 
						}
					},			
			"plugins" : ["dnd", "types"]
		}).bind("move_node.jstree", function (e, data) {
			var parent_id = data.parent;
			var category_id = data.node.id;
			
			var l = "/growtize/backend/web/index.php?r=taxonomy/category/update_parent&parent_id=" + parent_id + "&category_id=" + category_id;
			$.get(l,function(data){
				//document.location.href = "/growtize/backend/web/index.php?r=taxonomy/category/main&store_id=" + store_id + "&category_id=" + category_id + "&edit_mode=Y";
			});

        });		
   
		// Drag & drop
		$("#tree_4").jstree({
			"core" : {
				"themes" : {
					"responsive" : false
				},
				// so that create works
				"check_callback" : true,
				'data' : [{
					"text" : "Parent Node",
					"children" : [{
						"text" : "Initially selected",
						"state" : {
							"selected" : true
						}
					}, {
						"text" : "Custom Icon",
						"icon" : "fa fa-warning text-orange"
					}, {
						"text" : "Initially open",
						"icon" : "fa fa-folder text-green",
						"state" : {
							"opened" : true
						},
						"children" : [{
							"text" : "Another node",
							"icon" : "fa fa-file text-red"
						}]
					}, {
						"text" : "Another Custom Icon",
						"icon" : "fa fa-warning text-red"
					}, {
						"text" : "Disabled Node",
						"icon" : "fa fa-check text-green",
						"state" : {
							"disabled" : true
						}
					}, {
						"text" : "Sub Nodes",
						"icon" : "fa fa-folder text-orange",
						"children" : [{
							"text" : "Item 1",
							"icon" : "fa fa-file text-red"
						}, {
							"text" : "Item 2",
							"icon" : "fa fa-file text-green"
						}, {
							"text" : "Item 3",
							"icon" : "fa fa-file text-azure"
						}, {
							"text" : "Item 4",
							"icon" : "fa fa-file text-orange"
						}, {
							"text" : "Item 5",
							"icon" : "fa fa-file text-azure"
						}]
					}]
				}, "Another Node"]
			},
			"types" : {
				"default" : {
					"icon" : "fa fa-folder text-red fa-lg"
				},
				"file" : {
					"icon" : "fa fa-file text-red fa-lg"
				}
			},
			"state" : {
				"key" : "demo2"
			},
			"plugins" : ["search", "types"]
		});
		var to = false;
		$('#tree_4_search').keyup(function() {
			if (to) {
				clearTimeout(to);
			}
			to = setTimeout(function() {
				var v = $('#tree_4_search').val();
				$('#tree_4').jstree(true).search(v);
			}, 250);
		});
	};
	return {
		//main function to initiate template pages
		init : function(store_id) {
			runTreeView(store_id);
		}
	};
}();
