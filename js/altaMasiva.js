window.addEventListener("load", function()
{
    //Capturamos el input:file
    const fichero=this.document.getElementById("csv").addEventListener('change', leeArchivo, false);
    const aceptar=this.document.getElementById("aceptar");
    const form=this.document.getElementsByTagName("form")[0];
    const textarea=form.children[2];

    function obtenerLineasCSV(text) 
    {
        // Obtenemos las lineas del texto
        let lineas = text.replace(/\r/g, '').split('\n');
        return lineas.map(linea => {
        // Por cada linea obtenemos los valores
        let valores = linea.split(',');
        return valores;
        });
    }
    
    function leeArchivo(evt) 
    {
        if(this.files.length!=0)
        {
            if(/^text\//.test(this.files[0].type))
            {
                let file = evt.target.files[0];
                let reader = new FileReader();
                reader.onload = function(ev){
                // Cuando el archivo se terminó de cargar
                let lineas = obtenerLineasCSV(ev.target.result);
                //Recorremos el array de las líneas que tiene el fichero csv
                lineas.forEach(linea => {
                    //Por cada línea vemos cuantos campos tiene y los recorremos uno a uno
                    for(let i=0;i<linea.length;i++)
                    {
                        textarea.value+=linea[i];
                        //Comprobamos si es el último
                        if((i+1)==linea.length)
                        {
                            if((lineas.length-1)!=i)
                            {
                                //Si es el último valor de la línea añadimos un enter
                                textarea.value+="\n";
                            }
                        }else
                        {
                            //SI no es el último valor de la línea añadimos ; para separar los campos
                            textarea.value+=";";
                        }
                    }
                });
                };
                // Leemos el contenido del archivo seleccionado
                reader.readAsBinaryString(file);
            }
            else
            {
                this.value="";
                alert("Selecciona un fichero csv");
            }
        }
    }
})