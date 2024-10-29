const tela = ['index.php','sobre.php', 'Login.php', 'CadastroUsuarios.php',
            'perfil.php', 'logout.php', 'carrinho.php', 'AlterarProdutos.php',
            'ExcluirUsuarios.php', 'incluir.php', 'excluir.php', 'finalizarCompra.php',
            'AlterarUsuarios.php','produtos.php', 'usuarios.php', 'esqueci.php']
            /*  
                00 01 02 03 
                04 05 06 07
                08 09 10 11
                12 13 14 15
            */
const aside = $("aside")
const divFiltro = $("#divFiltro")
const select = $('#selectFiltro')
const btAside = $('#imgAside')
const btAcres = $('#inputDesconto');
const totalCarrinho = $('#total').html(); 
const btComprar = $('#btComprar');

divFiltro.css("display", "none");
aside.on('mouseenter', () =>{
    divFiltro.css("position", "absolute")
    divFiltro.css('display' , "inline")
    divFiltro.css('top', 80)
    divFiltro.css('width', '100%');
    select.css('width','80%');
    btAside.css('right',16);
})
aside.on('mouseleave', () => {
    btAside.css('right',10)
    divFiltro.css("display", 'none');
})

select.change(() => {
    window.open("index.php?filtro=" + select.val(), "_self");
})

function mudarTela(num){
    window.open(tela[num],"_self")  
} 
function btnComprar(conn, idProduto){
    if(conn){
        window.open("comprar.php?id=" + idProduto, "_self");
    }else{
        window.open("Login.php", "_self");
    }
}
function opcPerfil(num, id, idPrincipal){
    window.open(tela[num] + "?id=" +id + "&idPrincipal=" + idPrincipal,"_self") 
}
function incExCarrinho(num, idProd, idCompra){
    
    window.open(tela[num] + "?id=" +idProd + "&compra=" + idCompra,"_self") 
    
}
function admBt(num, idUsuario){
    window.open(tela[num] + "?id=" +idUsuario ,"_self") 
}


