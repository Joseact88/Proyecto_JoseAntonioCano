function generaContrasenya(num)
{
    const caracteres ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.-_,+*^';
    let resultado= "";
    const longitudcaracteres = caracteres.length;
    for(let i=0;i<num;i++) 
    {
        result += caracteres.charAt(Math.floor(Math.random() * longitudcaracteres));
    }
    return result;
}
function tablaOrdenable()
{
    //capturamos todos los elementos ordenables
    const tablas=document.getElementsByTagName("table");
    //Recorremos todas las tablas encontradas
    for(let i=0;i<tablas.length;i++)
    {
        var tablaTh=tablas[i].tHead.getElementsByTagName("th");
        //Recorremos todos los th para ver cual es ordenable y con qué criterio
        for(let j=0;j<tablaTh.length;j++)
        {
            var Th=tablaTh[j];
            //Vemos si tiene la clase ordenable
            if (Th.classList.contains("ordenable"))
            {
                //Si tiene la clase ordenable kla ordenaremos según si tiene int o no
                if(Th.classList.contains("int"))
                {
                    Th.ondblclick=ordenarTabla(j,"int",i);
                }else{
                    Th.ondblclick=ordenarTabla(j,"str",i);
                }
            }
        }
    }
}
//Devuelve la función ordenaTabla para poder añadirla al evento
function ordenarTabla(n,tipo,posicionTabla)
{
    return function()
    {   
        ordenaTabla(n,tipo,posicionTabla);
    }
}
//Función que añade el poder ordenar por columna
function ordenaTabla(n,tipo,posicionTabla) 
{
    var tabla, filas;
    var cambio, deberiaCambiar,cuentaCambios = 0;
    var i, x, y;
    var direccion;
    var tablas=document.getElementsByTagName("table");

    tabla = tablas[posicionTabla];
    cambio = true;
    //Queremos que la primera ordenacion sea en sentido ascendente
    direccion = "asc";

    while (cambio) {
        //Cambiamos el cambio a falso
        cambio = false;
        filas = tabla.rows;
        //Bucle que recorre las filas
        for (i = 1; i < (filas.length - 1); i++) {
            //Cambiamos el deberiaCambiar a falso
            deberiaCambiar = false;
            //Cogemos las dos filas que queremos comparar
            x = filas[i].getElementsByTagName("TD")[n];
            y = filas[i + 1].getElementsByTagName("TD")[n];
            //Comparamos si lo queremos ascendente o descendiente
            if (direccion == "asc") 
            {
            if ((tipo=="str" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) || (tipo=="int" && parseFloat(x.innerHTML) > parseFloat(y.innerHTML))) 
            {
                
                deberiaCambiar= true;
                break;
            }
            } 
            else if (direccion == "desc") 
            {
            if ((tipo=="str" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) || (tipo=="int" && parseFloat(x.innerHTML) < parseFloat(y.innerHTML))) 
            {
                
                deberiaCambiar = true;
                break;
            }
            }
        }
        if (deberiaCambiar) 
        {
            
            filas[i].parentNode.insertBefore(filas[i + 1], filas[i]);
            cambio = true;

            cuentaCambios ++;
        } 
        else 
        {
            
            if (cuentaCambios == 0 && direccion == "asc") 
            {
                direccion = "desc";
                cambio = true;
            }
        }
    }
}

function validacionCorreo()
{
    /*/^.+\@.+[.com]/*/
    const cajasTexto=document.getElementsByTagName("input")[type=text];
}

/*function validaCajasDeTexto()
{
    //
    const inputs=document.getElementsByTagName("input");
    const cajasTexto=[];
    for(let i=0;i<inputs.length;i++)
    {
        if(inputs[i].type=="text")
        {
            cajasTexto.push(inputs[i]);
        }
    }
    for(let i=0;i<cajasTexto.length;i++)
    {
        if(cajasTexto[i].classList.contains("onlyInt"))
        {
            cajasTexto[i].onkeydown=devuelveSoloNumeros(event);
        }
    }
}

function devuelveSoloNumeros()
{
    return function()
    {   
        soloNumeros(e);
    }
}*/
function soloNumeros(e)
{
	var key = window.Event ? e.which : e.keyCode
	return ((key >= 48 && key <= 57) || (key==8))
}