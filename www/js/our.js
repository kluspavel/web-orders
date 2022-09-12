//-----------------------------------------------------------------------------------
// Zavření chybové hlášky
//-----------------------------------------------------------------------------------
function closeErrorMessage()
{
    var errMsg = document.getElementById("errorMessage");
    errMsg.classList.add('hidden');
    //alert("I am an alert box!");
}
//-----------------------------------------------------------------------------------
// Načtení obrázku ze složky
//-----------------------------------------------------------------------------------
function openFileBrowser()
{
    var customTxt = document.getElementById("filename");
    var headImg = document.getElementById("image");
    var imgFile = document.getElementById("frm-userEditForm-avatar");
    imgFile.click();

    imgFile.addEventListener("change", function()
    {
        const file = this.files[0];

        if (file)
        {
            const reader = new FileReader();

            reader.addEventListener("load", function()
            {
                headImg.setAttribute("src", this.result);
            });

            reader.readAsDataURL(file);
        }
        else
        {
            headImg.setAttribute("src", "img/avatars/default-avatar.png");
        }

        if (imgFile.value)
        {
            var fileSource = "img/avatars/" + imgFile.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
            //customTxt.setAttribute('value' , fileSource);
            //customTxt.innerHTML = fileSource;
        }
        else
        {
            //customTxt.setAttribute('value' , '');
            //customTxt.innerHTML = "Není zvolena žádná fotka.";
        }
    });
}









//-----------------------------------------------------------------------------------
// Zobrazení a skrytí políček pro zadání hesla
//-----------------------------------------------------------------------------------
function showPasswordInput()
{
    const password = document.querySelector('#password');

    const origPass = document.querySelector('#frm-userEditForm-origpass');
    const newPass = document.querySelector('#frm-userEditForm-newpass');
    const checkPass = document.querySelector('#frm-userEditForm-checkpass');

    if (password.classList.contains('hidden')) 
    {
        //alert("Remove hidden");
        password.classList.remove('hidden');
    } 
    else 
    {
        //alert("Hidden");
        password.classList.add('hidden');

        origPass.value = '';
        newPass.value = '';
        checkPass.value = '';
    }
}

























