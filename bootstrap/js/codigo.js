function noback() {
    window.location.hash = "no-back-button";
    window.location.hash = "Again-No-back-button"
    window.onhashchange = function() { window.location.hash = "no-back-button"; }
}

// ndiv = div donde se mostrara la info ajax
// dhttp =  direccion php a direccionar
// vi = variable que nos permitira cambiar entre entre mas detalle menos detalle
function loadDoc(ndiv, dhttp, vi) {
    //alert(dhttp);
    console.log(ndiv);
    if (vi == "0") {
        document.getElementById(ndiv).innerHTML = "";
        return;
    } else {
        var texto = "<br><img src='img/loading.gif' alt='Enviando' width='100'><br>Ejecutando consulta. Por favor espere.<br><br>";
        document.getElementById(ndiv).innerHTML = texto;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(ndiv).innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", dhttp, true);
        xhttp.send();
    }
}

// se desplegara en ndiv el resultado de la busqueda de str 
function busqueda_general(ndiv, dhttp, vi, str) {
    var longitud = str.length;
    if (longitud == 0) {
        document.getElementById(ndiv).innerHTML = "";
    } else if ((longitud % 2) == 0) { loadDoc(ndiv, dhttp + "&busp=" + str, vi); }
}

// se desplegara en ndiv el resultado de la busqueda de str 
function busqueda_general2(ndiv, dhttp, vi, str) {
    var longitud = str.length;
    if (longitud == 0) {
        document.getElementById(ndiv).innerHTML = "";
    } else if ((longitud % 2) == 0) { loadDoc(ndiv, dhttp + "?busp=" + str, vi); }
}

//inphi = imput hiden que se recalculara con vinphi 
function gentede(ndiv, dhttp, vi, inphi, str) {
    var longitud = str.length;
    if (longitud == 0) {
        document.getElementById(ndiv).innerHTML = "";
        document.getElementById(inphi).value = "0";
    } else if ((longitud % 2) == 0) { loadDoc(ndiv, dhttp + "?busp=" + str, vi); }
}

//inphi = imput hiden que se recalculara con vinphi 
//vinphi = valor que tomara la variable inphi
function respuesta_gentede(inphi, vinphi, inpstr, vinpstr, ndiv) {
    document.getElementById(inphi).value = vinphi;
    document.getElementById(inpstr).value = vinpstr;
    document.getElementById(ndiv).innerHTML = "";
}

//funcion para Borrar
function borrar_caso(ndiv, dhttp, vi) { //Se guardara TODO{
    var r = confirm("ATENCION!! se Borrara UN PROCESO DE PAGO, esto es IRREBERSIBLE, Esta seguro?? : ");
    if (r == true) {
        loadDoc(ndiv, dhttp, vi);
    }
}

// ndiv = div donde se mostrara la info ajax
// dhttp =  direccion php a direccionar
// e =  evento de la tecla enter
// vi = variable que nos permitira cambiar entre entre mas detalle menos detalle
function busqueda(ndiv, dhttp, e, vi) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) {
        loadDoc(ndiv, dhttp, vi);
    }
}

//validar solo numeros enteros
function solonumeros(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla == 8) return true; // 3
    //if (tecla==46) return true; // 3
    patron = /\d/; // Solo acepta números
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
}

function sumar1() {
    var n1 = document.getElementById('predios').value;
    var n2 = document.getElementById('construcciones').value;
    var n3 = document.getElementById('ucas').value;
    var n4 = document.getElementById('centroides').value;
    var n5 = 0;
    if (isNaN(n1)) { n1 = 0; }
    if (isNaN(n2)) { n2 = 0; }
    if (isNaN(n3)) { n3 = 0; }
    if (isNaN(n4)) { n4 = 0; }
    n5 = Number(n1) + Number(n2) + Number(n3) + Number(n4);
    document.getElementById('total').innerHTML = "Total: " + n5;
}

function sumarVotos() {
    var total = 0;
    var ausentes = 0;
    var frm = document.forms[0];
    var habilitados = frm.elements[0].value;
    //document.getElementsByName('habilitados').value;
    habilitados = parseInt(habilitados);
    var k = 0;
    for (j = 0; j < frm.elements.length; j++) {
        if (frm.elements[j].type == "text") {
            k = j;
        }
    }

    for (i = 0; i < frm.elements.length; i++) {
        if (i != k) {
            if (frm.elements[i].type != "hidden") {
                if (!isNaN(parseInt(frm.elements[i].value))) { total = total + parseInt(frm.elements[i].value); }
            }
        }
    }
    ausentes = habilitados - total;
    //alert(ausentes);
    frm.elements[k].value = ausentes;
}

//calcular el posible total
//ve = valor entero que entra a la funcion
function calcular() {
    var n1 = document.getElementById('preu').value;
    var n2 = document.getElementById('cant').value;
    var n3 = 0;
    if (!isNaN(n2)) {
        n3 = n1 * n2;
    }
    document.getElementById('tota').innerHTML = n3;
}

//funcion para Borrar
function borrar_propietario(ndiv, dhttp, vi) { //Se guardara TODO{
    var r = confirm("ATENCION!! se Borrara un REGISTRO Esta seguro?? : ");
    if (r == true) {
        loadDoc(ndiv, dhttp, vi);
    }
}

//funcion para preguntar si se inhabilitar persona 
function inhabilitarP(ndiv, dhttp, nombre, vi) { //Se guardara TODO{
    var r = confirm("ATENCION!! se Inhabilitara a la persona " + nombre + "\n Si tiene asignado delegaciones las mismas seran eliminadas Esta seguro?? : ");
    if (r == true) {
        loadDoc(ndiv, dhttp, vi);
    }
}

//funcion para preguntar si se habilitara persona 
function habilitarP(ndiv, dhttp, nombre, vi) { //Se guardara TODO{
    var r = confirm("ATENCION!! Habilitara a la persona " + nombre + "\n Esta seguro?? : ");
    if (r == true) {
        loadDoc(ndiv, dhttp, vi);
    }
}

//funcion para preguntar si se bloqueara un uaurio 
function bloquearUsuario(ndiv, dhttp, nombre, vi) { //Se guardara TODO{
    var r = confirm("ATENCION!! se Bloqueara al usuario " + nombre + "\n Esta seguro?? : ");
    if (r == true) {
        loadDoc(ndiv, dhttp, vi);
    }
}

//funcion para preguntar si se desbloqueara un uaurio 
function desbloquearUsuario(ndiv, dhttp, nombre, vi) { //Se guardara TODO{
    var r = confirm("ATENCION!! se Desbloqueara al usuario " + nombre + "\n Esta seguro?? : ");
    if (r == true) {
        loadDoc(ndiv, dhttp, vi);
    }
}

//funcion para preguntar se reeestablecera la contraseña del usario 
function reestablecerPassword(ndiv, dhttp, nombre, vi) { //Se guardara TODO{
    var r = confirm("ATENCION!! se la contraseña a 123456 del usuario " + nombre + "\n Esta seguro?? : ");
    if (r == true) {
        loadDoc(ndiv, dhttp, vi);
    }
}


function ocultar_mostrar_mesa(vrol) {
    if (vrol == '1') {
        document.getElementById('mesa').style.display = 'none';
    } else {
        document.getElementById('mesa').style.display = 'block';
    }
}

function mayusc(v) {
    return v.toUpperCase();
}

function enviar_formulario(nameform, div, dhttp) {
    console.log('FORM: ',div);
    var frm = document.forms[nameform];
    var oOutput = document.getElementById(div);
    var texto = "<br><img src='img/loading.gif' alt='Enviando' width='150'><br>Ejecutando consulta. Por favor espere.<br><br>";
    oOutput.innerHTML = texto;
    var miObjeto = new Object();
    var variable = "";
    for (i = 0; i < frm.elements.length; i++) {
        if (frm.elements[i].type != "button") {
            if (frm.elements[i].type == "checkbox") {
                if (frm.elements[i].checked) { miObjeto[frm.elements[i].id] = "1"; } else { miObjeto[frm.elements[i].id] = "0"; }
            } else {
                miObjeto[frm.elements[i].id] = frm.elements[i].value;
            }
        }
    }
    //console.log(JSON.stringify(miObjeto));
    var oData = new FormData();
    oData.append("data", JSON.stringify(miObjeto));
    var oReq = new XMLHttpRequest();
    oReq.open("POST", dhttp, true);
    oReq.onload = function() {
        if (oReq.status == 200) {
            oOutput.innerHTML = this.responseText;
        } else {
            oOutput.innerHTML = "Error " + oReq.status + " ocurrio mientras se envia el formulario <br \/>";
        }
    };
    oReq.send(oData);
}

function enviar_voto(div, dhttp) {
    var frm = document.forms[0];
    var candidatos = [];
    var votos = [];
    var idvoto = [];
    var cadjson = "";
    for (i = 0; i < frm.elements.length; i++) {
        if (i > 3) {
            if (frm.elements[i].type != "hidden") {
                idvoto.push(frm.elements[i - 2].value);
                candidatos.push(frm.elements[i - 1].value);
                votos.push(frm.elements[i].value);
            }
        }
    }
    votos.pop();
    votos.pop();
    candidatos.pop();
    candidatos.pop();
    idvoto.pop();
    idvoto.pop();

    var oOutput = document.getElementById(div);
    var texto = "<br><img src='img/loading.gif' alt='Enviando' width='150'><br>Ejecutando consulta. Por favor espere.<br><br>";
    oOutput.innerHTML = texto;

    var mes_id = frm.elements[1].value;
    var noc_id = frm.elements[2].value;
    var cir_id = frm.elements[3].value;
    var oData = new FormData();
    oData.append("mes_id", mes_id);
    oData.append("noc_id", noc_id);
    oData.append("cir_id", cir_id);
    oData.append("candidato", JSON.stringify(candidatos));
    oData.append("voto", JSON.stringify(votos));
    oData.append("idvoto", JSON.stringify(idvoto));
    var oReq = new XMLHttpRequest();
    oReq.open("POST", dhttp, true);
    oReq.onload = function() {
        if (oReq.status == 200) {
            oOutput.innerHTML = this.responseText;
        } else {
            oOutput.innerHTML = "Error " + oReq.status + " ocurrio mientras se envia el formulario de Votos.<br \/>";
        }
    };
    oReq.send(oData);
}

function enviar_file(nameform, div, dhttp) {
    var frm = document.forms[nameform];
    //console.log(frm);
    var oOutput = document.getElementById(div);
    var texto = "<br><img src='img/loading.gif' alt='Enviando' width='150'><br>Enviando Archivo. Por favor espere.<br><br>";
    oOutput.innerHTML = texto;
    var ref_id = frm.elements.namedItem('ref_id').value;
    var chivo = frm.elements.namedItem('archivo');
    var oData = new FormData();
    oData.append("ref_id", ref_id);
    oData.append("file", chivo.files[0]);
    var oReq = new XMLHttpRequest();
    oReq.open("POST", dhttp, true);
    oReq.onload = function() {
        if (oReq.status == 200) {
            oOutput.innerHTML = this.responseText;
        } else {
            oOutput.innerHTML = "Error " + oReq.status + " ocurrio mientras se enviaba el Archivo.<br \/>";
        }
    };
    oReq.send(oData);
}

function enviar_filee(nameform, div, dhttp) {
    var frm = document.forms[nameform];
    //console.log(frm);
    var oOutput = document.getElementById(div);
    var texto = "<br><img src='img/loading.gif' alt='Enviando' width='150'><br>Enviando Archivo. Por favor espere.<br><br>";
    oOutput.innerHTML = texto;
    var ent_id = frm.elements.namedItem('ent_id').value;
    var chivo = frm.elements.namedItem('archivo');
    var oData = new FormData();
    oData.append("ent_id", ent_id);
    oData.append("file", chivo.files[0]);
    var oReq = new XMLHttpRequest();
    oReq.open("POST", dhttp, true);
    oReq.onload = function() {
        if (oReq.status == 200) {
            oOutput.innerHTML = this.responseText;
        } else {
            oOutput.innerHTML = "Error " + oReq.status + " ocurrio mientras se enviaba el Archivo.<br \/>";
        }
    };
    oReq.send(oData);
}