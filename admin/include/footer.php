<!-- Main page footer -->
<footer id="footer">
    <div class="container">
        <!-- Footer info -->
        <p>&copy; <?=date('Y');?><strong> <?=ADMIN_PANEL_NAME?></strong></p>

        <!-- Footer back to top -->
        <a href="#top" class="btn btn-alt"><span class="icon-arrow-up"></span></a>
    </div>
</footer>
<!-- /Main page footer -->

<!-- Bootstrap scripts -->
<script src="js/bootstrap/bootstrap.min.js"></script>

<!-- Fileupload and Inputmask plugin -->
<script src="js/plugins/fileupload/bootstrap-fileupload.js"></script>
<script src="js/plugins/inputmask/bootstrap-inputmask.js"></script>

<!-- Button switch -->
<script src="js/plugins/bootstrapSwitch/bootstrapSwitch.js"></script>

<!-- jQuery TagsInput -->
<script src="js/plugins/tagsInput/jquery.tagsinput.min.js"></script>

<script>
	$(document).ready(function() {
	
		$('.tagsinput').tagsInput();
	
	});
</script>

<!-- jQuery jWYSIWYG -->
<script src="js/plugins/jWYSIWYG/jquery.wysiwyg.js"></script>

<script>
$(document).ready(function() {
	$('.wysiwyg').wysiwyg({
		controls: {
			bold          : { visible : true },
			italic        : { visible : true },
			underline     : { visible : true },
			strikeThrough : { visible : true },
			
			justifyLeft   : { visible : true },
			justifyCenter : { visible : true },
			justifyRight  : { visible : true },
			justifyFull   : { visible : true },

			indent  : { visible : true },
			outdent : { visible : true },

			subscript   : { visible : true },
			superscript : { visible : true },
			
			undo : { visible : true },
			redo : { visible : true },
			
			insertOrderedList    : { visible : true },
			insertUnorderedList  : { visible : true },
			insertHorizontalRule : { visible : true },
			
			cut   : { visible : true },
			copy  : { visible : true },
			paste : { visible : true }
		},
		events: {
			click: function(event) {
				if ($("#click-inform:checked").length > 0) {
					event.preventDefault();
					alert("You have clicked jWysiwyg content!");
				}
			}
		}
	});
});
</script>

<!-- Wysihtml5 -->
<script src="js/plugins/wysihtml5/wysihtml5-0.3.0.js"></script>
<script src="js/plugins/wysihtml5/bootstrap-wysihtml5.js"></script>
<script>
$(document).ready(function() {
	// Note, we are adding .btn-alt to toolbar template directly in bootstrap-wysihtml5.js for better readability
	$('.wysihtml5').wysihtml5({
		"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
		"emphasis": true, //Italics, bold, etc. Default true
		"lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
		"html": true, //Button which allows you to edit the generated HTML. Default false
		"link": true, //Button to insert a link. Default true
		"image": true, //Button to insert an image. Default true,
		"color": false, //Button to change color of font  
		parser: function(html) {
			return html;
		}
	});
});
</script>

<!-- Datepicker -->
<script src="js/plugins/datepicker/bootstrap-datepicker.js"></script>
<script>
$(document).ready(function() {
	$('.datepicker').datepicker({
		"autoclose": true
	});
});
</script>

<!-- Timepicker -->
<script src="js/plugins/bootstrapTimePicker/bootstrap-timepicker.min.js"></script>
<script>
$(document).ready(function() {
	$('.timepicker').timepicker({
		minuteStep: 5,
		showInputs: false,
		disableFocus: true
	});
});
</script>

<!-- Custom checkbox and radio -->
<script src="js/plugins/prettyCheckable/prettyCheckable.js"></script>
<script>
	$(document).ready(function() {
		$('.custom-checkbox input, .custom-radio input').prettyCheckable();
	});
</script>

<!-- jQuery DataTable -->
<script src="js/plugins/dataTables/jquery.datatables.min.js"></script>
<script>
/* Default class modification */
$.extend( $.fn.dataTableExt.oStdClasses, {
	"sWrapper": "dataTables_wrapper form-inline"
} );

/* API method to get paging information */
$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
{
	return {
		"iStart":         oSettings._iDisplayStart,
		"iEnd":           oSettings.fnDisplayEnd(),
		"iLength":        oSettings._iDisplayLength,
		"iTotal":         oSettings.fnRecordsTotal(),
		"iFilteredTotal": oSettings.fnRecordsDisplay(),
		"iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
		"iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
	};
}

/* Bootstrap style pagination control */
$.extend( $.fn.dataTableExt.oPagination, {
	"bootstrap": {
		"fnInit": function( oSettings, nPaging, fnDraw ) {
			var oLang = oSettings.oLanguage.oPaginate;
			var fnClickHandler = function ( e ) {
				e.preventDefault();
				if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
					fnDraw( oSettings );
				}
			};
			
			$(nPaging).addClass('pagination').append(
				'<ul>'+
					'<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
					'<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
				'</ul>'
			);
			var els = $('a', nPaging);
			$(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
			$(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
		},
		
		"fnUpdate": function ( oSettings, fnDraw ) {
			var iListLength = 5;
			var oPaging = oSettings.oInstance.fnPagingInfo();
			var an = oSettings.aanFeatures.p;
			var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);
			
			if ( oPaging.iTotalPages < iListLength) {
				iStart = 1;
				iEnd = oPaging.iTotalPages;
			}
			else if ( oPaging.iPage <= iHalf ) {
				iStart = 1;
				iEnd = iListLength;
			} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
				iStart = oPaging.iTotalPages - iListLength + 1;
				iEnd = oPaging.iTotalPages;
			} else {
				iStart = oPaging.iPage - iHalf + 1;
				iEnd = iStart + iListLength - 1;
			}
			
			for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
				// Remove the middle elements
				$('li:gt(0)', an[i]).filter(':not(:last)').remove();
				
				// Add the new list items and their event handlers
				for ( j=iStart ; j<=iEnd ; j++ ) {
					sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
					$('<li '+sClass+'><a href="#">'+j+'</a></li>')
						.insertBefore( $('li:last', an[i])[0] )
						.bind('click', function (e) {
							e.preventDefault();
							oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
							fnDraw( oSettings );
						} );
				}
				
				// Add / remove disabled classes from the static elements
				if ( oPaging.iPage === 0 ) {
					$('li:first', an[i]).addClass('disabled');
				} else {
					$('li:first', an[i]).removeClass('disabled');
				}
				
				if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
					$('li:last', an[i]).addClass('disabled');
				} else {
					$('li:last', an[i]).removeClass('disabled');
				}
			}
		}
	}
});

/* Show/hide table column */
function dtShowHideCol( iCol ) {
	var oTable = $('#table_pagination').dataTable();
	var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
	oTable.fnSetColumnVis( iCol, bVis ? false : true );
};

/* Table #example */
$(document).ready(function() {
	$('.datatable').dataTable( {
		"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page"
		},
		"bSort" : false
	});
	$('.datatable-controls').on('click','li input',function(){
		dtShowHideCol( $(this).val() );
	})
});
</script>

<script type="text/javascript">
$(document).ready(function() {
	$('#table-23').DataTable( {
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		//"stateSave": true,
		"columnDefs": [
			{ "orderable": false, "targets": 2 },
			{ "orderable": false, "targets": 4 },
			{ "orderable": false, "targets": 5 },
		],
		//"pageLength": <?=$records_per_page?>,
		//"order": []
	});
});
</script>
</body>
</html>

<?php
//Close db connection of mysql
mysqli_close($db); ?>
