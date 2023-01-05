import gestion_infos_devoir from "/assets/scripts/gestion_devoir/gestion_infos_devoir.js";
import gestion_notes from "/assets/scripts/gestion_devoir/gestion_notes.js";

if (devoir){
    gestion_infos_devoir("form-info-devoir", devoir);
    gestion_notes("result-devoir", devoir.IDDEVOIR);
}
