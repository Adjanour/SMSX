
    //menutoggle
    let toggle = document.querySelector('.toggle');
    let navigation = document.querySelector('.navigation');
    let main = document.querySelector('.main');
    let contact = document.querySelector('.contact')

    toggle.onclick = function(){
    navigation.classList.toggle('active');
    main.classList.toggle('active');
    contact.classList.toggle('active')
    }
    //add the hovered class in selected list//
    let list = document.querySelectorAll('.navigation li');
    function activeLink(){
    list.forEach((item) =>
    item.classList.remove('hovered'));
    this.classList.add('hovered');
    }
    list.forEach((item) =>
    item.addEventListener('mouseover',activeLink));