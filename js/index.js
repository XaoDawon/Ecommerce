const tela = ['index.php','sobre.php', 'Login.php', 'CadastroUsuarios.php','perfil.php', 'logout.php', 'Carrinho.php']

function mudarTela(num , user){
    console.log(num);
    if(num == 4){
        window.open(tela[num] +"?id=" + user, "_self")
    }
    else{
       window.open(tela[num],"_self") 
    }
    
    
} 
