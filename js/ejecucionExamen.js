window.addEventListener("load", function()
{
    //Capturamos los campos
    const form=document.getElementsByTagName("form")[0];
    const h1Pregunta=document.getElementById("pregunta");
    const main=document.getElementById("preguntas");
    const mainBotones=document.getElementById("botones");
    const paginator=document.getElementById("botones");
    const botonesAdicionales=form.getElementsByTagName("button");
    const finalizar=document.getElementById("finalizar");
    //Span del reloj
    const reloj = document.getElementById('reloj');
    const idExamen=form.name;
    var pantalla=1;
    //Variables recogidas con JSON
    var examen=[];
    var preguntas=[];
    var respuestas=[];

    //Hacemos un ajax para conseguir todas las preguntas y sus respuestas
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
        cuentaAtras(examen.duracion*60*1000, "reloj", "GAME OVER");
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
                const listaPreguntas=main.getElementsByTagName("article");
                //Recorremos todos los botones para quitarle la clase activo
                for(let j=0;j<listaBotones.length;j++)
                {
                    listaBotones[j].classList.remove("activo");
                    if(j!=listaBotones.length)
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
    //Función que pinta las preguntas
    function pintaPreguntas()
    {
        var textoPreguntas='';
        var clase="";
        var recurso="";
        //Recorremos la lista de preguntas
        for (let i=0;i<preguntas.length;i++)
        {
            if(i!=0)
            {
                //Si no es la primera la ponemos oculta
                clase="oculto";
            }
            //Creamos el html de la pregunta
            textoPreguntas+="<article id='pregunta_"+i+"' class='"+clase+"'>";
            textoPreguntas+="<section class='enunciado'>"+preguntas[i].enunciado+"</section>";
            textoPreguntas+="<section class='respuestas'>";
            //Recorremos las respuestas de la pregunta
            for(let j=0;j<respuestas[i].length;j++)
            {
                //Creamos el html de las respuestas
                textoPreguntas+="<p><input type='radio' name='respuesta_"+preguntas[i].idPregunta+"' id='idRespuesta_"+respuestas[i][j].idRespuesta+"'>"+respuestas[i][j].respuesta+"\n</p>";
            }
            //Creamos y añadimos la imagen (si tiene)
            if(preguntas[i].recurso!=null)
            {
                //Creamos el html de la imagen
                var imagen="<img src='../../"+preguntas[i].recurso+"'>";
                recurso="<div class='imagenPregunta'>"+imagen+"</div>";
            }
            textoPreguntas+="</section>"+recurso+"</article>";
        }
        main.innerHTML=textoPreguntas;
    }
    function creaOnclickBotonesLados()
    {
        //Capturamos todos los botones
        const listaBotones=mainBotones.getElementsByTagName("input");
        const listaRespuestas=document.getElementsByClassName("respuestas");
        botonesAdicionales[0].onclick=function()
        {
            //Recorremos los botones para ver cual es el que estaba activo
            for(let j=0;j<listaBotones.length;j++)
            {
                //Si es el último no hacemos nada
                if(j!=listaBotones.length-1)
                {
                    //Buscamos el activo
                    if(listaBotones[j].classList.contains("activo"))
                    {
                        //Eliminamos el activo
                        listaBotones[j].classList.remove("activo");
                        for(let k=0;k<4;k++)
                        {
                            if(listaRespuestas[7-j].children[k].firstElementChild.checked==true)
                            {
                                //Le ponemos la clase respondida
                                listaBotones[j].classList.add("respondida");
                                //Rompemos el bucle
                                break;
                            }
                        }
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
            for(let j=0;j<listaBotones.length;j++)
            {
                //La lista se coge al revés, es decir, el número 1 está en la octava posición
                //Si es el último no hacemos nada
                if(j!=0)
                {
                    //Buscamos el activo
                    if(listaBotones[j].classList.contains("activo"))
                    {
                        //Eliminamos el activo
                        listaBotones[j].classList.remove("activo");
                        //vemos si ha contestado alguna
                        for(let k=0;k<4;k++)
                        {
                            if(listaRespuestas[7-j].children[k].firstElementChild.checked==true)
                            {
                                //Le ponemos la clase respondida
                                listaBotones[j].classList.add("respondida");
                                //Rompemos el bucle
                                break;
                            }
                        }
                        
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
        finalizar.onclick= function(ev)
        {
            ev.preventDefault();
            //Creamos el formData
            var formData = new FormData();
            // Añadimos todas las respuestas en un JSON
            formData.append("accion", creaJSONRespuesta());
            formData.append("finalizar", "");
            //Creamos el ajax
            const ajax = new XMLHttpRequest();

            ajax.onreadystatechange = function()
            {
                //Vemos si su status es correcto
                if(ajax.readyState==4 && ajax.status==200)
                {
                    window.location="../tablas/examenes.php";
                }
            }
            ajax.open("POST","../ejecucion/examen.php?examen="+idExamen);

            ajax.send(formData);
        }
    }
    //Función que crea el JSON con todas las respuestas y las preguntas
    function creaJSONRespuesta()
    {
        let listaPreguntas=document.getElementsByClassName("enunciado");
        let listaRespuestas=document.getElementsByClassName("respuestas");
        var preguntas=[];
        var respondidas=[];
        var jsonRespuesta=[];
        for(let i=0; i<listaPreguntas.length;i++)
        {
            //Añadimos los enunciados de las preguntas
            preguntas.push(listaPreguntas[i].textContent);
            for(let j=0;j<4;j++)
            {
                //Comprobamos cual es la respuesta correcta
                var respuesta=listaRespuestas[i].children[j].children[0];
                if(respuesta.checked==true)
                {
                    //Si es la correcta guardamos su id y rompemos el bucle
                    var idRespuesta=respuesta.id.split("_")[1];
                    break;
                }
            }
            //Añadimos las respuestas separadas por un \n por pregunta y le escribimos la opcion seleccionada
            respondidas.push(listaRespuestas[i].textContent+"seleccionada:"+idRespuesta);
        }
        jsonRespuesta.push(preguntas);
        jsonRespuesta.push(respondidas);
        return JSON.stringify(jsonRespuesta);
    }

    const obtieneTiempoRestante= miliSegundos =>{
        //Le sumamos 1s para que no vaya retrasado 1s el contador
        let tiempoRestante= (miliSegundos + 1000) / 1000;
        //Le añadimos el 0 como string para que cuando tenfa solo un número se le añada un 0
        let segundosRestantes= ('0'+Math.floor(tiempoRestante%60)).slice(-2);
        let minutosRestantes= ('0'+Math.floor(tiempoRestante/60%60)).slice(-2);
        let horasRestantes= ('0'+Math.floor(tiempoRestante/3600%60)).slice(-2);
        //Devolvemos un objeto con los 3 datos
        return {
            tiempoRestante, segundosRestantes, minutosRestantes, horasRestantes
        }
    }
    function cuentaAtras(miliSegundos, nombreElemento, mensajeFinal)
    {
        const elemento=document.getElementById(nombreElemento);

        var intervalo=setInterval( function(){
            miliSegundos-=1000;let tiempo= obtieneTiempoRestante(miliSegundos);
            elemento.innerHTML=tiempo.horasRestantes+":"+tiempo.minutosRestantes+":"+tiempo.segundosRestantes;
            if(tiempo.tiempoRestante <=1){
                clearInterval(intervalo);
                elemento.innerHTML=mensajeFinal;
                finalizar.click();
            }
        }, 1000)
    }
})