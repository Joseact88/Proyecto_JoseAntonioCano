window.addEventListener("load", function()
{
    const aceptar=this.document.getElementByName("aceptar");
    const form=this.document.getElementById("form1");
    const tematica=this.document.getElementById("tematica");
    const enunciado=this.document.getElementById("enunciado");
    const op1=this.document.getElementById("op1");
    const op2=this.document.getElementById("op2");
    const op3=this.document.getElementById("op3");
    const op4=this.document.getElementById("op4");
    const correcta=form.correcta;
    const fichero=form["imagen"];


    aceptar.onclick=function(ev)
    {
        ev.preventDefault();
        
        var formData= new FormData();
        if(fichero.files.length!=0)
        {
            if(/^image\//.test(fichero.files[0].type))
            {
                var reader = new FileReader();
                reader.readAsDataURL(fichero.files[0]);
                
                formData.append("imagen",fichero.files[0]);
            }
            else
            {
                alert("Selecciona una imagen");
            }
        }
        const ajax=new XMLHttpRequest();
        formData.append("aceptar","aceptar");
        formData.append("tematica",tematica.value);
        formData.append("enunciado",enunciado.value);
        formData.append("op1",op1.value);
        formData.append("op2",op2.value);
        formData.append("op3",op3.value);
        formData.append("op4",op4.value);
        formData.append("correcta",correcta.value);
        ajax.open("POST","altaPreguntas.php");
        ajax.send(formData);
        tematica.value="-1";
        enunciado.value="";
        op1.value="";
        op2.value="";
        op3.value="";
        op4.value="";
        correcta[0].checked="checked";
        fichero.value="";
    }
})