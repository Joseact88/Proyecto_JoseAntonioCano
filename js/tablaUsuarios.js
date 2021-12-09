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
        ajax.open("GET","../formularios/respuestaJSONTablas.php?tabla=usuario&numero="+numero+"&pagina="+pagina);

        ajax.send(formData);
    }
    
    creaBotones();
    function crearContenido(respuesta)
    {
        //Creamos la fila
        const tr=document.createElement("tr");
        //Creamos las celdas
        var td1=document.createElement("td");
        td1.innerHTML=respuesta.nombre;
        var td2=document.createElement("td");
        td2.innerHTML=respuesta.correo;
        var td3=document.createElement("td");
        td3.innerHTML=respuesta.numExamenes;
        var td4=document.createElement("td");
        //td4.innerHTML="<input type='submit' id='eliminar"+respuesta.id+"'";
        //Añadimos las celdas a la fila
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        //Añadimos la fila al tbody de la tabla
        tbody.appendChild(tr);
    }

    function creaBotones()
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
    comboNumero.onchange=function()
    {
        var valorCombo=comboNumero.value;
        tamanyoForm=valorCombo*100;
        tamanyoTabla=tamanyoForm-170;
        form.style="height: "+tamanyoForm+"px";
        tabla.style="height: "+tamanyoTabla+"px";
        switch (valorCombo) {
            case 5:
              break;
            case 10:
              //Declaraciones ejecutadas cuando el resultado de expresión coincide con el valor2
              break;
            case 15:
              //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
              break;
          }
        llamadaAjax(pantalla,valorCombo);
    }
})