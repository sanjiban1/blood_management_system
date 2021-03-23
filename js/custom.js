(function ($) {

	/* Featured */
	$('.donner-gallery').owlCarousel({
		loop: false,
		autoplay: true,
		margin: 30,
		nav: true,
		navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			520: {
				items: 2
			},
			750: {
				items: 3
			},
			1000: {
				items: 4
			}
		}
	});

	/* Featured */
	$('.featured-gallery').owlCarousel({
		loop: false,
		autoplay: true,
		margin: 30,
		nav: true,
		navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 3
			}
		}
	});

	/* Testimonia */
	$('.testimonial-gallery').owlCarousel({
		loop: false,
		autoplay: true,
		margin: 30,
		nav: false,
		navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});

	/* Latest News */
	$('.latest-gallery').owlCarousel({
		loop: false,
		autoplay: true,
		margin: 30,
		nav: true,
		navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 3
			}
		}
	});

	/* Car Detail */
	$('.car-detail-gallery').owlCarousel({
		loop: false,
		margin: 30,
		nav: true,
		navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});
	
 	
 	/* Scroll-Top */
    $(".scroll").hide();

    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $(".scroll").fadeIn();
        } else {
            $(".scroll").fadeOut();
        }
    });

    $(".scroll").click(function () {
        $("html, body").animate({
            scrollTop: 0,
        }, 550)
    });
	

	$(window).on('load',function() {
		$('#preloader').fadeOut();
		$('#preloader-status').delay(200).fadeOut('slow');
		$('body').delay(200).css({
			'overflow-x': 'hidden'
		});

		$("#btnAddNew1").on('click',function() {

	        var rowNumber = $("#CarTable tbody tr").length;

	        var trNew = "";              

	        var addLink = "<div class=\"upload-btn" + rowNumber + "\"><input type=\"file\" name=\"photos[]\"></div>";
	           
	        var deleteRow = "<a href=\"javascript:void()\" class=\"Delete btn btn-danger btn-xs\">X</a>";

	        trNew = trNew + "<tr> ";

	        trNew += "<td>" + addLink + "</td>";
	        trNew += "<td style=\"width:28px;\">" + deleteRow + "</td>";

	        trNew = trNew + " </tr>";

	        $("#CarTable tbody").append(trNew);

	    });

	    $('#CarTable').delegate('a.Delete', 'click', function () {
	        $(this).parent().parent().fadeOut('slow').remove();
	        return false;
	    });
	});

	$(document).ready(function(){
		$(".brand").chosen().change(function(){
			var id=$(this).val();
			var dataString = 'id='+ id;
			$.ajax
			({
				type: "POST",
				url: "get-model.php",
				data: dataString,
				cache: false,
				success: function(html)
				{
					$(".model").html(html);
				}
			});
			
		});
		$( ".datepicker" ).datepicker({
			dateFormat: "yy-mm-dd",
			gotoCurrent: true,
			showButtonPanel: true,
		    changeMonth: true,
		    changeYear: true,
		    showOtherMonths: true,
		    selectOtherMonths: true
		});
	});

	//Collapse
	$('.faq-accordion').collapse({
		accordion: true,
		open: function () {
			this.slideDown(400);
		},
		close: function () {
			this.slideUp(400);
		}
	});
	
	$('#example').DataTable();
	
	//Slicknav
	$('#nav').slicknav();

	//Chosen
	new Chosen($("chosen_select_field"),{no_results_text: "Oops, nothing found!"});

	


})(jQuery);