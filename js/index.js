const tela = ['index.php','sobre.php', 'Login.php', 'CadastroUsuarios.php','perfil.php', 'logout.php', 'Carrinho.php']
const aside = $("aside")
const divFiltro = $("#divFiltro")
const select = $('#selectFiltro')
const btAside = $('#imgAside')



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
