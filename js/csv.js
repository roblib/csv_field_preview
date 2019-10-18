(function ($, Drupal, drupalSettings) {
    Drupal.behaviors.csv_field_preview = {
        attach: function (context, settings) {

            var handsontableContainer = context.getElementsByClassName("csv-preview");
            for (file of handsontableContainer)
            {
                var url = file.getAttribute('file');
                var content = "";

                let xhr = new XMLHttpRequest();
                xhr.open('GET', url);
                xhr.responseType = "";

                xhr.onload = function () {
                    let content = xhr.response;

                    var data = Papa.parse(content, {
                        header: true,
                        skipEmptyLines: true
                    });

                    // reset container
                    handsontableContainer.innerHTML = '';

                    Handsontable(file, {
			data: data.data,
			colWidths: 100,
			width: '100%',
			height: 320,
			rowHeights: 23,
			rowHeaders: true,                                  colHeaders: data.meta.fields
	   	    });
                };
		xhr.send();
                
            }
        }
    };
})(jQuery, Drupal, drupalSettings);
