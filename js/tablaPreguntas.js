window.addEventListener("load", function()
{
    //Capturamos los campos
    const tabla=this.document.getElementsByTagName("table")[0];
    const form=tabla.parentNode;
    const tbody=tabla.children[1];
    const paginator=this.document.getElementById("paginator");
    const comboNumero=this.document.getElementById("comboNumero");
    var pantalla=1;
    llamadaAjax(1,comboNumero.value);
    function llamadaAjax(pagina, numero)
    {
        //Limpiamos la tabla
        tbody.innerHTML="";
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
                for(let i=0;i<respuesta.length;i++)
                {
                    //Metemos cada alumno que haya dentro del json recibido
                    crearContenido(respuesta[i], i);
                }
            }
        }
        ajax.open("GET","../formularios/respuestaJSONTablas.php?tabla=pregunta&numero="+numero+"&pagina="+pagina);

        ajax.send(formData);
    }
    creaBotonesPaginator();
    function crearContenido(respuesta)
    {
        //Creamos la fila
        const tr=document.createElement("tr");
        //Creamos las celdas
        var td1=document.createElement("td");
        td1.innerHTML=respuesta.enunciado;
        var td2=document.createElement("td");
        td2.innerHTML=respuesta.descripcion;
        var td3=document.createElement("td");
        var span1=document.createElement("span");
        span1.className='fas fa-edit editar';
        span1.id="editarPregunta_"+respuesta.idPregunta;
        var span2=document.createElement("span");
        span2.className='fas fa-trash eliminar';
        span2.id="eliminarPregunta_"+respuesta.idPregunta;
        td3.appendChild(span1);
        td3.appendChild(span2);
        //LE añadimos los eventos de click a los iconos
        span2.onclick=function() {
            //Capturamos el id del pregunta
            var idPregunta = this.id.split("_")[1];
            //Activamos el modal de confirmación
            modal.style.display = "block";
            var aceptar=document.getElementById("confirmar");
            var denegar=document.getElementById("denegar");
            aceptar.onclick=function(){
                modal.style.display = "none";
                ajaxEliminar(idPregunta);
                return false;
            }
            denegar.onclick=function(){
                modal.style.display = "none";
                return false;
            }
         }
        //Añadimos las celdas a la fila
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        //Añadimos la fila al tbody de la tabla
        tbody.appendChild(tr);
    }

    
    comboNumero.onchange=function()
    {
        var valorCombo=comboNumero.value;
        tamanyoForm=valorCombo*100;
        tamanyoTabla=tamanyoForm-170;
        form.style="height: "+tamanyoForm+"px";
        tabla.style="height: "+tamanyoTabla+"px";
        llamadaAjax(pantalla,valorCombo);
    }
    function creaBotonesPaginator()
    {
        for(let i=8; i>=0;i--)
        {
            var boton=document.createElement("input");
            boton.type="submit";
            boton.name=i;
            //Le damos el valor al boton
            if(i!=0 && i!=8)
            {
                boton.value=i;
                if(i==1)
                {
                    boton.className="activo";
                }
            }
            else
            {
                if(i==8)
                {
                    boton.value=">>";
                }else{
                    boton.value="<<";
                }
            }
            boton.onclick=function(ev)
            {
                //Capturamos todos los botones
                const listaBotones=document.getElementsByTagName("input");
                //Vemos si es un botón de un número
                if(this.name!=0 && this.name!=8)
                {
                    //Recorremos todos los botones para quitarle la clase activo
                    for(let j=1;j<listaBotones.length-1;j++)
                    {
                        listaBotones[j].classList.remove("activo");
                    }
                    //Le ponemos a este botón activo
                    this.classList.add("activo");
                    //Ponemos la pantalla en la que estamos
                    pantalla=this.name;
                    //Hacemos la llamada Ajax
                    llamadaAjax(pantalla,comboNumero.value);
                }else{
                    //Vemos si es el botón de retroceso
                    if(this.name!=0)
                    {
                        //Recorremos los botones para ver cual es el que estaba activo
                        for(let j=1;j<listaBotones.length-1;j++)
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
                                    //Hacemos la llamada Ajax
                                    llamadaAjax(pantalla,comboNumero.value);
                                }
                            }
                        }
                    }else{
                        //Recorremos los botones para ver cual es el que estaba activo
                        for(let j=1;j<listaBotones.length-1;j++)
                        {
                            //Si es el último no hacemos nada
                            if(j!=listaBotones.length-2)
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
                                    //Hacemos la llamada Ajax
                                    llamadaAjax(pantalla,comboNumero.value);
                                    //Rompemos el bucle para que la clase no vaya al botón de más a la izquierda
                                    break;
                                }
                            }
                        }
                    }
                }
                return false;
            }
            paginator.appendChild(boton);
        }
    }
    function ajaxEliminar(id)
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
                llamadaAjax(pantalla,comboNumero.value);
            }
        }
        ajax.open("GET","../formularios/eliminador.php?tabla=pregunta&id="+id);

        ajax.send(formData);
    }
})