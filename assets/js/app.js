import { async } from 'regenerator-runtime';
import '../css/app.scss';

document.addEventListener('DOMContentLoaded',()=>{
    new App();
})

class App{
    constructor(){
        this.handleCommentaireForm();
    }
    handleCommentaireForm(){

        const commentaireForm= document.querySelector('form.commentaire-form');
       
    
        if(null===  commentaireForm){
            return;
        }
        commentaireForm.addEventListener('submit', async(e)  =>{
            e.preventDefault();
            const response = await fetch ("/ajax/commentaire",{
                method: 'POST',
                body: new FormData(e.target)
            });

            if(!response.ok){
                return;
            }
            const json = await response.json();
        console.log(json);
        });
    }

}