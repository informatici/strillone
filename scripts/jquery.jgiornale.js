/* jGiornale : jQuery giornale parser plugin
 * Copyright (C) 2012 rodenic
 */

jQuery.getGiornale = function(options) {

    options = jQuery.extend({

        url: null,
        data: null,
        cache: true,
        success: null,
        failure: null,
        error: null,
        global: true

    }, options);

    if (options.url) {
        
        if (jQuery.isFunction(options.failure) && jQuery.type(options.error)==='null') {
          // Handle legacy failure option
          options.error = function(xhr, msg, e){
            options.failure(msg, e);
          }
        } else if (jQuery.type(options.failure) === jQuery.type(options.error) === 'null') {
          // Default error behavior if failure & error both unspecified
          options.error = function(xhr, msg, e){
            window.console&&console.log('getGiornale non riesce a caricare il file', xhr, msg, e);
          }
        }

        return $.ajax({
            type: 'GET',
            url: options.url,
            data: options.data,
            cache: options.cache,
            dataType: (jQuery.browser.msie) ? "text" : "xml",
            success: function(xml) {
                var feed = new JGiornale(xml);
                if (jQuery.isFunction(options.success)) options.success(feed);
            },
            error: options.error,
            global: options.global
        });
    }
};

function JGiornale(xml) {
    if (xml) this.parse(xml);
};

JGiornale.prototype = {

    edizione: '',
    parse: function(xml) {

        if (jQuery.browser.msie) {
            var xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
            xmlDoc.loadXML(xml);
            xml = xmlDoc;
        }

        if (jQuery('giornale', xml).length == 1) {
            this.type = 'brescia_on_line';
            var feedClass = new JBol(xml);
        }

        if (feedClass) jQuery.extend(this, feedClass);
    }
};

function JArticolo() {};

JArticolo.prototype = {
    titolo: '',
    testo: ''
};

function JSezione() {};

JSezione.prototype = {
    nome: ''
};

function JBol(xml) {
    this._parse(xml);
};

JBol.prototype  = {
    
    _parse: function(xml) {
    
        this.edizione = jQuery('giornale', xml).eq(0).find('edizione:first').text();
		
        this.sezioni = new Array();
		
        var feed = this;
        
        jQuery('sezione', xml).each(function(index) {
        
            var sezione = new JSezione();
            
            sezione.nome = jQuery(this).find('nome').eq(0).text();
			
            feed.sezioni.push(sezione);

			feed.sezioni[index].articoli = new Array();

			var indice_sezione = index;
			
			jQuery(this).find('articolo').each( function(index) {

				var articolo = new JArticolo();
				
				articolo.titolo = jQuery(this).find('titolo').eq(0).text();
				articolo.testo = jQuery(this).find('testo').eq(0).text();
				
				feed.sezioni[indice_sezione].articoli.push(articolo);

			});
			
        });
    }
};       
