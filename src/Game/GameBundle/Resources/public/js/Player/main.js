/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    
    playerInit();
    
    /* Fonction d'initialisation du player */
    function playerInit() {
        $('#player_gm_navbar_gamename').text('Coucou !');
        
        $('#player_gm_navbar_quit').click(function() {playerQuit();});
        
    }
    
    /* Fonction pour quitter le player */
    function playerQuit() {
        alert(console.log(Routing.generate('pm_game_public_home')));
        //document.location.href=pm_game_public_home;
        alert('oucou');
    }
});