window.addEventListener("load", function()
{
    //Capturamos los campos
    const form=document.getElementsByTagName("form")[0];
    const h1Pregunta=document.getElementById("pregunta");
    const main=document.getElementById("preguntas");
    const mainBotones=document.getElementById("botones");
    const paginator=this.document.getElementById("botones");
    const botonesAdicionales=form.getElementsByTagName("button");
    //Span del reloj
    const minutos = document.querySelector('span#minutos');
    const segundos = document.querySelector('span#segundos');
    const idExamen=form.name;
    var pantalla=1;
    //Variables recogidas con JSON
    var examen=[];
    var preguntas=[];
    var respuestas=[];

    llamadaAjax();
    function llamadaAjax()
    {
        //Creamos el formData
        var formData = new FormData();
        //Creamos el ajax
        const ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function()
        {
            //Vemos si su status es correcto
            if(ajax.readyState==4 && ajax.status==200)
            {
                //Capturamos la respuesta
                var respuesta =ajax.responseText;
                //Descodificamos la respuesta
                respuesta=JSON.parse(respuesta);
                //Metemos cada pregunta que haya dentro del json recibido
                crearContenido(respuesta);
            }
        }
        ajax.open("GET","../formularios/respuestaJSONExamen.php?examen="+idExamen);

        ajax.send(formData);
    }
    
    function crearContenido(respuesta)
    {
        examen=respuesta[0];
        preguntas=respuesta[1][0];
        respuestas=respuesta[1][1];
        
        pintaPreguntas();
        creaBotones(examen.numPreguntas);
        creaOnclickBotonesLados();
    }
    //Función que crea los botones de números del examen
    function creaBotones(numPreguntas)
    {
        for(let i=numPreguntas; i>=1;i--)
        {
            var boton=document.createElement("input");
            boton.type="submit";
            boton.name=i;
            //Le damos el valor al boton
            boton.value=i;
            if(i==1)
            {
                boton.className="activo";
                h1Pregunta.innerHTML="PREGUNTA "+1;
            }
            boton.onclick=function(ev)
            {
                //Capturamos todos los botones
                const listaBotones=mainBotones.getElementsByTagName("input");
                //Capturamos todos los article
                const listaPreguntas=document.getElementsByTagName("article");
                //Recorremos todos los botones para quitarle la clase activo
                for(let j=0;j<listaBotones.length;j++)
                {
                    listaBotones[j].classList.remove("activo");
                    if(j!=listaBotones.length-1)
                    {
                        listaPreguntas[j].classList.add("oculto");
                    }
                }
                //Le ponemos a este botón activo
                this.classList.add("activo");
                //Ponemos la pantalla en la que estamos
                pantalla=this.name;
                h1Pregunta.innerHTML="PREGUNTA "+this.name;
                //Recorremos todas los preguntas para añadirle la clase oculto
                listaPreguntas[this.name-1].classList.remove("oculto");
                //Return false para que no haga una peticion a la página
                return false;
            }
            paginator.appendChild(boton);
        }
        
    }
    function pintaPreguntas()
    {
        var textoPreguntas='';
        var clase="";
        for (let i=0;i<preguntas.length;i++)
        {
            if(i!=0)
            {
                clase="oculto";
            }
            textoPreguntas+="<article id='pregunta_"+i+"' class='"+clase+"'>";
            textoPreguntas+="<section class='enunciado'>"+preguntas[i].enunciado+"</section>";
            textoPreguntas+="<section class='respuestas'>";
            for(let j=0;j<respuestas[i].length;j++)
            {
                textoPreguntas+="<p><input type='radio' name='respuesta_"+preguntas[i].idPregunta+"'>"+respuestas[i][j].respuesta+"</p>";
            }
            textoPreguntas+="</section></article>";
        }
        main.innerHTML=textoPreguntas;
    }
    function creaOnclickBotonesLados()
    {
        //Capturamos todos los botones
        const listaBotones=mainBotones.getElementsByTagName("input");
        botonesAdicionales[0].onclick=function()
        {
            //Recorremos los botones para ver cual es el que estaba activo
            for(let j=1;j<listaBotones.length;j++)
            {
                //Si es el último no hacemos nada
                if(j!=listaBotones.length-1)
                {
                    //Buscamos el activo
                    if(listaBotones[j].classList.contains("activo"))
                    {
                        //Eliminamos el activo
                        listaBotones[j].classList.remove("activo");
                        //Ponemos activo el anterior
                        listaBotones[j+1].classList.add("activo");
                        //Ponemos la pantalla en la que estamos
                        pantalla=listaBotones[j+1].name;
                        listaBotones[j+1].onclick();
                        //Rompemos el bucle para que la clase no vaya al botón de más a la izquierda
                        break;
                    }
                }
            }
            return false;
        }
        botonesAdicionales[1].onclick=function()
        {
            //Recorremos los botones para ver cual es el que estaba activo
            for(let j=1;j<listaBotones.length;j++)
            {
                //La lista se coge al revés, es decir, el número 1 está en la octava posición
                //Si es el último no hacemos nada
                if(j!=1)
                {
                    //Buscamos el activo
                    if(listaBotones[j].classList.contains("activo"))
                    {
                        //Eliminamos el activo
                        listaBotones[j].classList.remove("activo");
                        //Ponemos activo el siguiente
                        listaBotones[j-1].classList.add("activo");
                        //Ponemos la pantalla en la que estamos
                        pantalla=listaBotones[j-1].name;
                        listaBotones[j-1].onclick();
                    }
                }
            }
            return false;
        }
        botonesAdicionales[2].onclick=function()
        {
            for(let i=1;i<listaBotones.length;i++)
            {
                if(listaBotones[i].name==pantalla)
                {
                    //listaBotones[i].classList.remove("activo");
                    //Le añadimos la clase revisar al botón de esta posición
                    listaBotones[i].classList.toggle("revisar");
                }
            }
            return false;
        }
    }
})