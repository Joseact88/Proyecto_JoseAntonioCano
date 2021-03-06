window.addEventListener("load", function()
{
    //Capturamos el botón aceptar
    const aceptar=this.document.getElementById("aceptar");
    const duracion=this.document.getElementById("duracion");
    const descripcion=this.document.getElementById("descripcion");
    const numPreguntas=this.document.getElementById("numPreguntas");
    numPreguntas.onpaste=function(ev){
        ev.preventDefault();
    }
    const tematica=this.document.getElementById("tematica");
    const contador=document.getElementById("contador");
    //Capturamos los botones donde van las preguntas
    const contenedorPreguntas=this.document.getElementById("tbodyPreguntas");
    const contenedorPreguntasExamen=this.document.getElementById("tbodyPreguntasExamen");
    const tablaPreguntas=this.document.getElementById("preguntas");
    const tablaPreguntasExamen=this.document.getElementById("preguntasExamen");
    //Capturamos el buscador
    const filtro=document.getElementById("filtro");
    //Añadimos un evento al filtro para que cuando pulse se actualice la búsqueda
    filtro.onkeyup=function()
    {
        const tablas=contenedorPreguntas.getElementsByTagName("tr");
        //Recorremos todas los tr
        for(let i=0;i<tablas.length;i++)
        {
            //Eliminamos la clase marcado de todos
            tablas[i].classList.remove("marcado");
            //Vemos si el contenido del tr es como lo que hay escrito en el filtro y si es así se le quita la clase oculto
            if(tablas[i].innerHTML.indexOf(filtro.value)<0)
            {
                tablas[i].classList.add("oculto");
            }
            else
            {
                tablas[i].classList.remove("oculto");
            }
        }
    }
    llamadaAjax();
    function llamadaAjax(){
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
                var respuesta = ajax.responseText;
                //Descodificamos la respuesta
                respuesta=JSON.parse(respuesta);
                for(let i=0;i<respuesta.length;i++)
                {
                    //Metemos cada pregunta que haya dentro del json recibido
                    crearContenido(respuesta[i], i);
                }
            }
        }
        ajax.open("POST","../formularios/respuestaJSONpreguntas.php");

        ajax.send(formData);
    }
    //Le añadimos el ordenable a las tablas
    tablaOrdenable();
    function crearContenido(respuesta, indice)
    {
        //Creamos la fila y lo ponemos draggable para poder arrastrarlo
        const tr=document.createElement("tr");
        tr.tema="tema_"+respuesta.idTematica;
        tr.draggable=true;
        tr.id="fila_"+respuesta.idPregunta;
        //Le añadimos el evento para empezar a arrastrarlo
        tr.ondragstart=function(ev)
        {
            ev.dataTransfer.setData("text", ev.target.id);
        }
        //Creamos las celdas
        var td1=document.createElement("td");
        td1.innerHTML=respuesta.enunciado;
        var td2=document.createElement("td");
        td2.innerHTML=respuesta.tematica;
        //Le añadimos el evento dragover a las celdas para poder poner la fila sobre ellas
        td1.ondragover=function(ev)
        {
            ev.preventDefault();
        }
        td2.ondragover=function(ev)
        {
            ev.preventDefault();
        }
        //Añadimos el evento drop para poder soltar la fila sobre las celdas
        td1.ondrop=function(ev)
        {
            
            if(td1.parentNode.parentNode.parentNode.id=="preguntas")
            {
                ev.preventDefault();
                //Paramos la propagación para que no llegue al evento de la fila
                ev.stopPropagation();
                var data = ev.dataTransfer.getData("text");
                const fila=ev.target.parentNode;
                //Insertamos la nueva fila 
                fila.parentNode.insertBefore(document.getElementById(data),fila);
                contador.value=contenedorPreguntasExamen.children.length;
            }
            if(contenedorPreguntasExamen.children.length<parseInt(numPreguntas.value))
            {
                ev.preventDefault();
                //Paramos la propagación para que no llegue al evento de la fila
                ev.stopPropagation();
                var data = ev.dataTransfer.getData("text");
                const fila=ev.target.parentNode;
                //Insertamos la nueva fila 
                fila.parentNode.insertBefore(document.getElementById(data),fila);
                contador.value=contenedorPreguntasExamen.children.length;
            }
        }
        td2.ondrop=function(ev)
        {
            if(td2.parentNode.parentNode.parentNode.id=="preguntas")
            {
                ev.preventDefault();
                //Paramos la propagación para que no llegue al evento de la fila
                ev.stopPropagation();
                var data = ev.dataTransfer.getData("text");
                const fila=ev.target.parentNode;
                //Insertamos la nueva fila 
                fila.parentNode.insertBefore(document.getElementById(data),fila);
                contador.value=contenedorPreguntasExamen.children.length;
            }
            if(contenedorPreguntasExamen.children.length<parseInt(numPreguntas.value))
            {
                ev.preventDefault();
                //Paramos la propagación para que no llegue al evento de la fila
                ev.stopPropagation();
                var data = ev.dataTransfer.getData("text");
                const fila=ev.target.parentNode;
                //Insertamos la nueva fila 
                fila.parentNode.insertBefore(document.getElementById(data),fila);
                contador.value=contenedorPreguntasExamen.children.length;
            }
        }
        //Añadimos las celdas a la fila
        tr.appendChild(td1);
        tr.appendChild(td2);
        //Añadimos la fila al tbody de la tabla
        contenedorPreguntas.appendChild(tr);
    }
    //Creamos el evento drop de la tabla del nuevo examen
    tablaPreguntasExamen.addEventListener("drop",function(ev) 
    {
        contador.value=1;
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");        
        ev.target.tBodies[0].appendChild(document.getElementById(data));
    });
    //Creamos el evento drop de la tabla de preguntas
    tablaPreguntas.addEventListener("drop",function(ev) 
    {
        contador.value=contenedorPreguntasExamen.children.length-1;
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");        
        ev.target.tBodies[0].appendChild(document.getElementById(data));
    });
    //Le añadimos el evento dragover a la tabla del nuevo examen para poder poner la fila sobre él
    tablaPreguntasExamen.addEventListener("dragover", function(ev)
    {
        ev.preventDefault();
    });
    //Le añadimos el evento dragover a la tabla de preguntas para poder poner la fila sobre él
    tablaPreguntas.addEventListener("dragover", function(ev)
    {
        ev.preventDefault();
    });
    //Capturamos el onclick del botón enviar
    aceptar.onclick=function(ev)
    {
        ev.preventDefault();
        if(duracion.value!="" && descripcion.value!="" && numPreguntas.value!="")
        {
            var preguntas=[];
            //Metemos todas las preguntas en un array
            for(let i=0;i<contenedorPreguntasExamen.childElementCount;i++)
            {
                preguntas.push(contenedorPreguntasExamen.children[i].id.split("_")[1]);
            }
            var texto=encodeURI("aceptar=aceptar&descripcion="+descripcion.value+"&duracion="+duracion.value+"&preguntasExamen="+preguntas+"&numPreguntas="+numPreguntas.value);
            const ajax=new XMLHttpRequest();
            
            ajax.open("POST","altaExamenes.php");
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.send(texto);
            //Vaciamos todos los campos de texto y la tabla de la derecha
            duracion.value="";
            descripcion.value="";
            numPreguntas.value="";
            tematica.value="-1";
            contador.value="0";
            contenedorPreguntas.innerHTML="";
            contenedorPreguntasExamen.innerHTML="";
            llamadaAjax();
        }else{
            const error=document.getElementById("error");
            error.innerText="Todos los campos deben estar completos";
            error.style="color:red";
        }
        
    }
    //Controlamos el envento onchange del comboBox
    tematica.onchange=function(ev)
    {
        ev.preventDefault();
        //Recorremos todas las preguntas de la tabla
        for(let i=0;i<contenedorPreguntas.children.length;i++)
        {
            let filaTematica=contenedorPreguntas.children[i];
            //Si está el sin seleccionar las mostramos todas
            if(tematica.value=="-1")
            {
                filaTematica.classList.remove("oculto");
            }
            else
            {
                //Vemos si la temática seleccionada es la temática de la pregunta
                if(tematica.value==filaTematica.tema.split("_")[1])
                {
                    //Si lo es eliminamos la clase oculto
                    filaTematica.classList.remove("oculto");
                }
                else
                {
                    //Si no lo es, se le añade la clase oculto
                    filaTematica.classList.add("oculto");
                }
            }
        }
    }
})