'use_strict'
var x=0;
var y=0;
var mapa = document.getElementById("map");
var arrayX = [];
var arrayY = [];
var latitud = 0;
var longitud = 0;
var arrayCoordenadas = [];
function inicio(){
    var file = document.getElementById("geolector")
    var formulario = document.getElementById("addparcela");

    file.onchange = leerValor;

}


function leerValor(event){
    var archivo = document.getElementById("geolector").files[0];
    if (archivo) {
        var reader = new FileReader();
        reader.readAsText(archivo, "UTF-8");
        reader.onload = function (evt) {
           // document.getElementById("fileContents").innerHTML = evt.target.result;
            let json = parsear(evt.target.result);
            leerParcela(json);
        }
        reader.onerror = function (evt) {
          //  document.getElementById("fileContents").innerHTML = "error reading file";
        }
    }
}

function parcelaObj(nparcela,municipio,provincia,npoligono,coordenadas){
    this.nparcela = nparcela;
    this.municipio = municipio;
    this.provincia = provincia;
    this.npoligono = npoligono;
    this.coordenadas = coordenadas;
}

function leerParcela(json){
    let formulario = document.getElementById("addparcela");
    var nparcela = document.getElementById("nparcela");
    var municipio = document.getElementById("municipio");
    var provincia = document.getElementById("provincia");
    var npoligono = document.getElementById("npoligono");
    var nCoordenadas = document.getElementById("coordenadas");

    for (let parcelam of json.features) {
    var parcela = new parcelaObj(parcelam.properties.parcela,parcelam.properties.municipio,parcelam.properties.provincia,parcelam.properties.poligono,parcelam.geometry.coordinates); 
    arrayParcelas.push(parcela);
    nparcela.value = parcela.nparcela;
    municipio.value = parcela.municipio;
    provincia.value = parcela.provincia;
    npoligono.value = parcela.npoligono;
    nCoordenadas.value = parcela.coordenadas;
   
    arrayCoordenadas = nCoordenadas.value.split(",");
    console.log(arrayCoordenadas);
    for(let i=0;i<arrayCoordenadas.length;i++){
        if(i == 0 || i %2 == 0){
           x = arrayCoordenadas[i];
           arrayX.push(x);
           //console.log("X : "+x);
        }else {
            y = arrayCoordenadas[i];
            arrayY.push(y);
            
            //console.log("Y : "+y);
        }
        
} 
        latitud = arrayX[0];
        longitud = arrayY[0];
        latitud = parseFloat(latitud);
        console.log(typeof(latitud));
        console.log("Latitud : "+latitud);
        latitud = parseFloat(longitud);
        console.log(typeof(longitud));
        console.log("Longitud : "+longitud);
      
       //Array X
       console.log("Array de X");
       console.log(arrayX);

       //Array Y
       console.log("Array de Y");
       console.log(arrayY);




//console.log(arrayParcelas);
  }
}




function initMap(x,y) {

    // La localizacion
    const localizacion = { lat: x, lng: y };
    // The map, centered at localizacion
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 4,
      center: localizacion,
    });
    // The marker, positioned at localizacion
    const marker = new google.maps.Marker({
      position: localizacion,
      map: map,
    });
  }


function parsear(str){
    try{
        let miobjGeoJSON = JSON.parse(str);
        return (miobjGeoJSON);
    }
    catch(err){
        alert(err.message);
        return{};
    }
}


var arrayParcelas = new Array();
window.onload = inicio;