function filemanager(id, value, type, win) {
	e=tinymce.activeEditor;
			t=id;
			a=type;
			s=win;
			
			var r = window.innerWidth - 30,
		g = window.innerHeight - 60;
	if (r > 1800 && (r = 1800), g > 1200 && (g = 1200), r > 600) {
		var d = (r - 20) % 138;
		r = r - d + 10
	}
	urltype = 2, "image" == a && (urltype = 1), "media" == a && (urltype = 3);
	var o = "RESPONSIVE FileManager";
	"undefined" != typeof e.settings.filemanager_title && e.settings.filemanager_title && (o = e.settings.filemanager_title);
	var l = "key";
	"undefined" != typeof e.settings.filemanager_access_key && e.settings.filemanager_access_key && (l = e.settings.filemanager_access_key);
	var f = "";
	"undefined" != typeof e.settings.filemanager_sort_by && e.settings.filemanager_sort_by && (f = "&sort_by=" + e.settings.filemanager_sort_by);
	var m = "false";
	"undefined" != typeof e.settings.filemanager_descending && e.settings.filemanager_descending && (m = e.settings.filemanager_descending);
	var c = "";
	"undefined" != typeof e.settings.filemanager_subfolder && e.settings.filemanager_subfolder && (c = "&fldr=" + e.settings.filemanager_subfolder);
	var v = "";
	"undefined" != typeof e.settings.filemanager_crossdomain && e.settings.filemanager_crossdomain && (v = "&crossdomain=1", window.addEventListener ? window.addEventListener("message", n, !1) : window.attachEvent("onmessage", n)), 
			tinymce.activeEditor.windowManager.open({
		title: o,
		file: e.settings.external_filemanager_path + "dialog.php?type=" + urltype + "&descending=" + m + f + c + v + "&lang=" + e.settings.language + "&akey=" + l,
		width: r,
		height: g,
		resizable: !0,
		maximizable: !0,
		inline: 1
	}, {
		setUrl: function(n) {
						//console.log(t);
			var i = s.document.getElementById(t);
			if (i.value = e.convertURL(n), "createEvent" in document) {
				var a = document.createEvent("HTMLEvents");
				a.initEvent("change", !1, !0), i.dispatchEvent(a)
			} else i.fireEvent("onchange")
		}
	})
}

tinymce.init({
  selector: '#description,#img_text,#bannertext,#detail',
  width: 800, height:400,
  extended_valid_elements : "a[*],strong/b,div[align|class],br,class,i[*],iframe[width|height|*]",
  plugins: [
'advlist autolink lists link image charmap print preview anchor',
'searchreplace visualblocks code fullscreen',
'insertdatetime media table contextmenu paste responsivefilemanager code',
'textcolor colorpicker textpattern '
],
image_advtab: true,
  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image forecolor backcolor fontsizeselect fontselect',
  external_filemanager_path:"filemanager/",
  filemanager_title:"Filemanager" ,
  content_css: ['https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700','https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i'],
	font_formats : "Andale Mono=andale mono,times;"+
        "Arial=arial,helvetica,sans-serif;"+
        "Arial Black=arial black,avant garde;"+
        "Book Antiqua=book antiqua,palatino;"+
        "Comic Sans MS=comic sans ms,sans-serif;"+
        "Courier New=courier new,courier;"+
        "Georgia=georgia,palatino;"+
        "Helvetica=helvetica;"+
        "Impact=impact,chicago;"+
        "Oswald=Oswald;"+
        "Roboto=Roboto;"+
        "Symbol=symbol;"+
        "Tahoma=tahoma,arial,helvetica,sans-serif;"+
        "Terminal=terminal,monaco;"+
        "Times New Roman=times new roman,times;"+
        "Trebuchet MS=trebuchet ms,geneva;"+
        "Verdana=verdana,geneva;"+
        "Webdings=webdings;"+
        "Wingdings=wingdings,zapf dingbats",
  
  external_plugins: { "filemanager" : "../filemanager/plugin.min.js"},
  file_browser_callback: function(field_name, url, type, win) {
		//console.log(field_name);
		func_value = win.document.getElementById(field_name).value;
		filemanager(field_name, func_value, type, win); 
	}
});