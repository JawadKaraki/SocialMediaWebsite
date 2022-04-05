//replace all images with this if an error happens
function ImageReplace(img){
    img.onerror = "";
    img.src = "https://cdn.dribbble.com/users/112330/screenshots/15505990/media/a40608176e1c04daeeb247d61f7c4d5f.png?compress=1&resize=400x300";
    return true;
}