var ajax;

var dadosUsuario;
var conteudo = null;

/**
 * @function isMobile
 * detecta se o useragent e um dispositivo mobile
 */
function isMobile()
{
	var userAgent = navigator.userAgent.toLowerCase();
	if( userAgent.search(/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i)!= -1 )
		return true;
}


// ----------------  Confere se o(s) campo(s) selecionado(s) marcado(s) com required foi/foram preenchido(s)  ---------------- //

// ---------------------- Cria o objeto XMLHttpRequest e Faz uma requisição ------------------ //
function requisicaoHttp(tipo, url){
    try{
        ajax = new XMLHttpRequest();
    } catch (e) {
        var versoes = new Array("MSXML2.XMLHTTP.6.0", "MSXML2.XMLHTTP.5.0", "MSXML2.XMLHTTP.4.0", "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP.3.0", "Microsoft.XMLHTTP");

        for(var i = 0; i < versoes.length && !ajax; i++){
                try{
                        ajax = new ActiveXObject(versoes[i]);
                } catch (e) {}
        }
    }

    if(ajax){
        iniciaRequisicao(tipo, url);
    }
    else{
        alert("Seu navegador não possui suporte a essa aplicação");
    }	
}


function requisicaoHttpFiles(tipo, url){
    try{
        ajax = new XMLHttpRequest();
    } catch (e) {
        var versoes = new Array("MSXML2.XMLHTTP.6.0", "MSXML2.XMLHTTP.5.0", "MSXML2.XMLHTTP.4.0", "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP.2.0", "Microsoft.XMLHTTP");

        for(var i = 0; i < versoes.length && !ajax; i++){
                try{
                        ajax = new ActiveXObject(versoes[i]);
                } catch (e) {}
        }
    }

    if(ajax){
        iniciaRequisicaoFILES(tipo, url);
    }
    else{
        alert("Seu navegador não possui suporte a essa aplicação");
    }	
}

// --------------------- Inicia o objeto criado e envia os dados (se houverem)----------------//
function iniciaRequisicao(url, params){
    ajax.open('POST', url, true);
    ajax.onreadystatechange = trataResposta;
    ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    ajax.setRequestHeader('Content-length', params.length);
    ajax.setRequestHeader('Connection','close');
    ajax.send(params);
}

// --------------------- Inicia o objeto criado e envia os arquivos ----------------//
function iniciaRequisicaoFILES(url, params){
    ajax.open('POST', url, true);
    ajax.onreadystatechange = trataResposta;
    ajax.setRequestHeader('Connection','close');
    ajax.send(params);
}


// -------------- Trata a resposta do servidor ---------------------//
function trataResposta(){
    if(ajax.readyState == 4){
            if(ajax.status == 200 || ajax.status == 0){
                    trataDados();
            }
            else{
                    alert("Problemas na comunicação com o objeto XMLHttpRequest");
            }
    } else {
            var callback = function(){
                    iniciaRequisicao(url, params);
            }
            setTimeout(callback, 1000);
    }
}

// ---------------- Decodifica a palavra de UTF-8 ------------------ //
function utf8_decode(str_data) {
  //  discuss at: http://phpjs.org/functions/utf8_decode/
  // original by: Webtoolkit.info (http://www.webtoolkit.info/)
  //    input by: Aman Gupta
  //    input by: Brett Zamir (http://brett-zamir.me)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Norman "zEh" Fuchs
  // bugfixed by: hitwork
  // bugfixed by: Onno Marsman
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: kirilloid
  //   example 1: utf8_decode('Kevin van Zonneveld');
  //   returns 1: 'Kevin van Zonneveld'

  var tmp_arr = [],
    i = 0,
    ac = 0,
    c1 = 0,
    c2 = 0,
    c3 = 0,
    c4 = 0;

  str_data += '';

  while (i < str_data.length) {
    c1 = str_data.charCodeAt(i);
    if (c1 <= 191) {
      tmp_arr[ac++] = String.fromCharCode(c1);
      i++;
    } else if (c1 <= 223) {
      c2 = str_data.charCodeAt(i + 1);
      tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
      i += 2;
    } else if (c1 <= 239) {
      // http://en.wikipedia.org/wiki/UTF-8#Codepage_layout
      c2 = str_data.charCodeAt(i + 1);
      c3 = str_data.charCodeAt(i + 2);
      tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
      i += 3;
    } else {
      c2 = str_data.charCodeAt(i + 1);
      c3 = str_data.charCodeAt(i + 2);
      c4 = str_data.charCodeAt(i + 3);
      c1 = ((c1 & 7) << 18) | ((c2 & 63) << 12) | ((c3 & 63) << 6) | (c4 & 63);
      c1 -= 0x10000;
      tmp_arr[ac++] = String.fromCharCode(0xD800 | ((c1 >> 10) & 0x3FF));
      tmp_arr[ac++] = String.fromCharCode(0xDC00 | (c1 & 0x3FF));
      i += 4;
    }
  }

  return tmp_arr.join('');
}

// ------------------ Codifica a palavra para UTF-8 -----------------//
function utf8_encode(argString) {
  //  discuss at: http://phpjs.org/functions/utf8_encode/
  // original by: Webtoolkit.info (http://www.webtoolkit.info/)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: sowberry
  // improved by: Jack
  // improved by: Yves Sucaet
  // improved by: kirilloid
  // bugfixed by: Onno Marsman
  // bugfixed by: Onno Marsman
  // bugfixed by: Ulrich
  // bugfixed by: Rafal Kukawski
  // bugfixed by: kirilloid
  //   example 1: utf8_encode('Kevin van Zonneveld');
  //   returns 1: 'Kevin van Zonneveld'

  if (argString === null || typeof argString === 'undefined') {
    return '';
  }

  var string = (argString + ''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
  var utftext = '',
    start, end, stringl = 0;

  start = end = 0;
  stringl = string.length;
  for (var n = 0; n < stringl; n++) {
    var c1 = string.charCodeAt(n);
    var enc = null;

    if (c1 < 128) {
      end++;
    } else if (c1 > 127 && c1 < 2048) {
      enc = String.fromCharCode(
        (c1 >> 6) | 192, (c1 & 63) | 128
      );
    } else if ((c1 & 0xF800) != 0xD800) {
      enc = String.fromCharCode(
        (c1 >> 12) | 224, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
      );
    } else { // surrogate pairs
      if ((c1 & 0xFC00) != 0xD800) {
        throw new RangeError('Unmatched trail surrogate at ' + n);
      }
      var c2 = string.charCodeAt(++n);
      if ((c2 & 0xFC00) != 0xDC00) {
        throw new RangeError('Unmatched lead surrogate at ' + (n - 1));
      }
      c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000;
      enc = String.fromCharCode(
        (c1 >> 18) | 240, ((c1 >> 12) & 63) | 128, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
      );
    }
    if (enc !== null) {
      if (end > start) {
        utftext += string.slice(start, end);
      }
      utftext += enc;
      start = end = n + 1;
    }
  }

  if (end > start) {
    utftext += string.slice(start, stringl);
  }

  return utftext;
}