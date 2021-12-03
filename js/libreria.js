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
