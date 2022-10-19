/*==============================================================*/
/* Nom de SGBD :  MySQL 4.0                                     */
/* Date de création :  19/10/2022 08:29:13                      */
/*==============================================================*/


drop table if exists ADMIN;

drop index AFFECTER2_FK on AFFECTER;

drop index AFFECTER_FK on AFFECTER;

drop table if exists AFFECTER;

drop index RELIER_FK on CONVERSATION_ADMIN;

drop table if exists CONVERSATION_ADMIN;

drop index EVALUER_MODULE_FK on DEVOIR;

drop index EVALUER_FK on DEVOIR;

drop table if exists DEVOIR;

drop index ENSEIGNER2_FK on ENSEIGNER;

drop index ENSEIGNER_FK on ENSEIGNER;

drop table if exists ENSEIGNER;

drop table if exists ETUDIANT;

drop table if exists GROUPE;

drop index ENVOYER_MESSAGE_ADMIN_FK on MESSAGE_ADMIN;

drop index RECEVOIR_MESSAGE_PROF_FK on MESSAGE_ADMIN;

drop index RECEVOIR_MESSAGE_ADMIN_FK on MESSAGE_ADMIN;

drop index ENVOYER_MESSAGE_PROF_FK on MESSAGE_ADMIN;

drop index CORRESPONDRE_FK on MESSAGE_ADMIN;

drop table if exists MESSAGE_ADMIN;

drop index RELATIF_A_MESSAGE_FK on MESSAGE_MODULE;

drop index ENVOYER_MESSAGE_MODULE_FK on MESSAGE_MODULE;

drop table if exists MESSAGE_MODULE;

drop table if exists MODULE;

drop index NOTER2_FK on NOTER;

drop index NOTER_FK on NOTER;

drop table if exists NOTER;

drop index PARTICIPER2_FK on PARTICIPER;

drop index PARTICIPER_FK on PARTICIPER;

drop table if exists PARTICIPER;

drop table if exists PROFESSEUR;

drop index RECEVOIR2_FK on RECEVOIR;

drop index RECEVOIR_FK on RECEVOIR;

drop table if exists RECEVOIR;

drop index REPONDRE2_FK on REPONDRE;

drop index REPONDRE_FK on REPONDRE;

drop table if exists REPONDRE;

drop index RELATIF_A_SONDAGE_FK on SONDAGE;

drop index ENVOYER_SONDAGE_FK on SONDAGE;

drop table if exists SONDAGE;

/*==============================================================*/
/* Table : ADMIN                                                */
/*==============================================================*/
create table ADMIN
(
   LOGINADMIN                     char(80)                       not null,
   PASSWORD_HASH                  char(50),
   primary key (LOGINADMIN)
)
type = InnoDB;

/*==============================================================*/
/* Table : AFFECTER                                             */
/*==============================================================*/
create table AFFECTER
(
   LOGINETU                       char(50)                       not null,
   INTITULEGROUPE                 char(10)                       not null,
   ANNEEGROUPE                    char(10)                       not null,
   primary key (LOGINETU, INTITULEGROUPE, ANNEEGROUPE)
)
type = InnoDB;

/*==============================================================*/
/* Index : AFFECTER_FK                                          */
/*==============================================================*/
create index AFFECTER_FK on AFFECTER
(
   LOGINETU
);

/*==============================================================*/
/* Index : AFFECTER2_FK                                         */
/*==============================================================*/
create index AFFECTER2_FK on AFFECTER
(
   INTITULEGROUPE,
   ANNEEGROUPE
);

/*==============================================================*/
/* Table : CONVERSATION_ADMIN                                   */
/*==============================================================*/
create table CONVERSATION_ADMIN
(
   IDCONV                         int                            not null,
   LOGINPROF                      char(50)                       not null,
   DATEDEBUTCONV                  date,
   primary key (IDCONV)
)
type = InnoDB;

/*==============================================================*/
/* Index : RELIER_FK                                            */
/*==============================================================*/
create index RELIER_FK on CONVERSATION_ADMIN
(
   LOGINPROF
);

/*==============================================================*/
/* Table : DEVOIR                                               */
/*==============================================================*/
create table DEVOIR
(
   INTITULEGROUPE                 char(10)                       not null,
   ANNEEGROUPE                    char(10)                       not null,
   REFMODULE                      char(10)                       not null,
   IDDEVOIR                       int                            not null,
   CONTENUDEVOIR                  char(50),
   DATEDEVOIR                     date,
   primary key (INTITULEGROUPE, ANNEEGROUPE, REFMODULE, IDDEVOIR)
)
type = InnoDB;

/*==============================================================*/
/* Index : EVALUER_FK                                           */
/*==============================================================*/
create index EVALUER_FK on DEVOIR
(
   INTITULEGROUPE,
   ANNEEGROUPE
);

/*==============================================================*/
/* Index : EVALUER_MODULE_FK                                    */
/*==============================================================*/
create index EVALUER_MODULE_FK on DEVOIR
(
   REFMODULE
);

/*==============================================================*/
/* Table : ENSEIGNER                                            */
/*==============================================================*/
create table ENSEIGNER
(
   LOGINPROF                      char(50)                       not null,
   REFMODULE                      char(10)                       not null,
   primary key (LOGINPROF, REFMODULE)
)
type = InnoDB;

/*==============================================================*/
/* Index : ENSEIGNER_FK                                         */
/*==============================================================*/
create index ENSEIGNER_FK on ENSEIGNER
(
   LOGINPROF
);

/*==============================================================*/
/* Index : ENSEIGNER2_FK                                        */
/*==============================================================*/
create index ENSEIGNER2_FK on ENSEIGNER
(
   REFMODULE
);

/*==============================================================*/
/* Table : ETUDIANT                                             */
/*==============================================================*/
create table ETUDIANT
(
   LOGINETU                       char(50)                       not null,
   PASSWORD_HASH                  char(50),
   PRENOMETU                      char(50),
   NOMETU                         char(50),
   primary key (LOGINETU)
)
type = InnoDB;

/*==============================================================*/
/* Table : GROUPE                                               */
/*==============================================================*/
create table GROUPE
(
   INTITULEGROUPE                 char(10)                       not null,
   ANNEEGROUPE                    char(10)                       not null,
   primary key (INTITULEGROUPE, ANNEEGROUPE)
)
type = InnoDB;

/*==============================================================*/
/* Table : MESSAGE_ADMIN                                        */
/*==============================================================*/
create table MESSAGE_ADMIN
(
   IDCONV                         int                            not null,
   IDMSGADMIN                     int                            not null,
   LOGINADMIN                     char(80),
   LOGINPROF                      char(50),
   ADM_LOGINADMIN                 char(80),
   PRO_LOGINPROF                  char(50),
   CONTENUMSGADMIN                char(500),
   DATEMSG                        date,
   primary key (IDCONV, IDMSGADMIN)
)
type = InnoDB;

/*==============================================================*/
/* Index : CORRESPONDRE_FK                                      */
/*==============================================================*/
create index CORRESPONDRE_FK on MESSAGE_ADMIN
(
   IDCONV
);

/*==============================================================*/
/* Index : ENVOYER_MESSAGE_PROF_FK                              */
/*==============================================================*/
create index ENVOYER_MESSAGE_PROF_FK on MESSAGE_ADMIN
(
   ADM_LOGINADMIN
);

/*==============================================================*/
/* Index : RECEVOIR_MESSAGE_ADMIN_FK                            */
/*==============================================================*/
create index RECEVOIR_MESSAGE_ADMIN_FK on MESSAGE_ADMIN
(
   LOGINADMIN
);

/*==============================================================*/
/* Index : RECEVOIR_MESSAGE_PROF_FK                             */
/*==============================================================*/
create index RECEVOIR_MESSAGE_PROF_FK on MESSAGE_ADMIN
(
   LOGINPROF
);

/*==============================================================*/
/* Index : ENVOYER_MESSAGE_ADMIN_FK                             */
/*==============================================================*/
create index ENVOYER_MESSAGE_ADMIN_FK on MESSAGE_ADMIN
(
   PRO_LOGINPROF
);

/*==============================================================*/
/* Table : MESSAGE_MODULE                                       */
/*==============================================================*/
create table MESSAGE_MODULE
(
   IDMESSAGE                      int                            not null,
   LOGINPROF                      char(50)                       not null,
   REFMODULE                      char(10)                       not null,
   OBJETMESSAGE                   text,
   CONTENUMESSAGE                 text,
   DATEMESSAGE                    date,
   primary key (IDMESSAGE)
)
type = InnoDB;

/*==============================================================*/
/* Index : ENVOYER_MESSAGE_MODULE_FK                            */
/*==============================================================*/
create index ENVOYER_MESSAGE_MODULE_FK on MESSAGE_MODULE
(
   LOGINPROF
);

/*==============================================================*/
/* Index : RELATIF_A_MESSAGE_FK                                 */
/*==============================================================*/
create index RELATIF_A_MESSAGE_FK on MESSAGE_MODULE
(
   REFMODULE
);

/*==============================================================*/
/* Table : MODULE                                               */
/*==============================================================*/
create table MODULE
(
   REFMODULE                      char(10)                       not null,
   NOMMODULE                      char(50),
   DESCRIPTIONMODULE              text,
   primary key (REFMODULE)
)
type = InnoDB;

/*==============================================================*/
/* Table : NOTER                                                */
/*==============================================================*/
create table NOTER
(
   LOGINETU                       char(50)                       not null,
   INTITULEGROUPE                 char(10)                       not null,
   ANNEEGROUPE                    char(10)                       not null,
   REFMODULE                      char(10)                       not null,
   IDDEVOIR                       int                            not null,
   NOTE                           float(5),
   COMMENTAIRE                    char(50),
   primary key (INTITULEGROUPE, ANNEEGROUPE, REFMODULE, LOGINETU, IDDEVOIR)
)
type = InnoDB;

/*==============================================================*/
/* Index : NOTER_FK                                             */
/*==============================================================*/
create index NOTER_FK on NOTER
(
   LOGINETU
);

/*==============================================================*/
/* Index : NOTER2_FK                                            */
/*==============================================================*/
create index NOTER2_FK on NOTER
(
   INTITULEGROUPE,
   ANNEEGROUPE,
   REFMODULE,
   IDDEVOIR
);

/*==============================================================*/
/* Table : PARTICIPER                                           */
/*==============================================================*/
create table PARTICIPER
(
   INTITULEGROUPE                 char(10)                       not null,
   ANNEEGROUPE                    char(10)                       not null,
   REFMODULE                      char(10)                       not null,
   primary key (INTITULEGROUPE, ANNEEGROUPE, REFMODULE)
)
type = InnoDB;

/*==============================================================*/
/* Index : PARTICIPER_FK                                        */
/*==============================================================*/
create index PARTICIPER_FK on PARTICIPER
(
   INTITULEGROUPE,
   ANNEEGROUPE
);

/*==============================================================*/
/* Index : PARTICIPER2_FK                                       */
/*==============================================================*/
create index PARTICIPER2_FK on PARTICIPER
(
   REFMODULE
);

/*==============================================================*/
/* Table : PROFESSEUR                                           */
/*==============================================================*/
create table PROFESSEUR
(
   LOGINPROF                      char(50)                       not null,
   PASSWORD_HASH                  char(50),
   PRENOMETU                      char(50),
   NOMETU                         char(50),
   primary key (LOGINPROF)
)
type = InnoDB;

/*==============================================================*/
/* Table : RECEVOIR                                             */
/*==============================================================*/
create table RECEVOIR
(
   IDMESSAGE                      int                            not null,
   INTITULEGROUPE                 char(10)                       not null,
   ANNEEGROUPE                    char(10)                       not null,
   primary key (IDMESSAGE, INTITULEGROUPE, ANNEEGROUPE)
)
type = InnoDB;

/*==============================================================*/
/* Index : RECEVOIR_FK                                          */
/*==============================================================*/
create index RECEVOIR_FK on RECEVOIR
(
   IDMESSAGE
);

/*==============================================================*/
/* Index : RECEVOIR2_FK                                         */
/*==============================================================*/
create index RECEVOIR2_FK on RECEVOIR
(
   INTITULEGROUPE,
   ANNEEGROUPE
);

/*==============================================================*/
/* Table : REPONDRE                                             */
/*==============================================================*/
create table REPONDRE
(
   LOGINETU                       char(50)                       not null,
   IDSONDAGE                      int                            not null,
   CONTENUREPONSE                 JSON500,
   primary key (LOGINETU, IDSONDAGE)
)
type = InnoDB;

/*==============================================================*/
/* Index : REPONDRE_FK                                          */
/*==============================================================*/
create index REPONDRE_FK on REPONDRE
(
   LOGINETU
);

/*==============================================================*/
/* Index : REPONDRE2_FK                                         */
/*==============================================================*/
create index REPONDRE2_FK on REPONDRE
(
   IDSONDAGE
);

/*==============================================================*/
/* Table : SONDAGE                                              */
/*==============================================================*/
create table SONDAGE
(
   IDSONDAGE                      int                            not null,
   REFMODULE                      char(10)                       not null,
   LOGINPROF                      char(50)                       not null,
   CONTENUSONDAGE                 JSON500,
   primary key (IDSONDAGE)
)
type = InnoDB;

/*==============================================================*/
/* Index : ENVOYER_SONDAGE_FK                                   */
/*==============================================================*/
create index ENVOYER_SONDAGE_FK on SONDAGE
(
   LOGINPROF
);

/*==============================================================*/
/* Index : RELATIF_A_SONDAGE_FK                                 */
/*==============================================================*/
create index RELATIF_A_SONDAGE_FK on SONDAGE
(
   REFMODULE
);

alter table AFFECTER add constraint FK_AFFECTER foreign key (LOGINETU)
      references ETUDIANT (LOGINETU) on delete restrict on update restrict;

alter table AFFECTER add constraint FK_AFFECTER2 foreign key (INTITULEGROUPE, ANNEEGROUPE)
      references GROUPE (INTITULEGROUPE, ANNEEGROUPE) on delete restrict on update restrict;

alter table CONVERSATION_ADMIN add constraint FK_RELIER foreign key (LOGINPROF)
      references PROFESSEUR (LOGINPROF) on delete restrict on update restrict;

alter table DEVOIR add constraint FK_EVALUER foreign key (INTITULEGROUPE, ANNEEGROUPE)
      references GROUPE (INTITULEGROUPE, ANNEEGROUPE) on delete restrict on update restrict;

alter table DEVOIR add constraint FK_EVALUER_MODULE foreign key (REFMODULE)
      references MODULE (REFMODULE) on delete restrict on update restrict;

alter table ENSEIGNER add constraint FK_ENSEIGNER foreign key (LOGINPROF)
      references PROFESSEUR (LOGINPROF) on delete restrict on update restrict;

alter table ENSEIGNER add constraint FK_ENSEIGNER2 foreign key (REFMODULE)
      references MODULE (REFMODULE) on delete restrict on update restrict;

alter table MESSAGE_ADMIN add constraint FK_CORRESPONDRE foreign key (IDCONV)
      references CONVERSATION_ADMIN (IDCONV) on delete restrict on update restrict;

alter table MESSAGE_ADMIN add constraint FK_ENVOYER_MESSAGE_ADMIN foreign key (PRO_LOGINPROF)
      references PROFESSEUR (LOGINPROF) on delete restrict on update restrict;

alter table MESSAGE_ADMIN add constraint FK_ENVOYER_MESSAGE_PROF foreign key (ADM_LOGINADMIN)
      references ADMIN (LOGINADMIN) on delete restrict on update restrict;

alter table MESSAGE_ADMIN add constraint FK_RECEVOIR_MESSAGE_ADMIN foreign key (LOGINADMIN)
      references ADMIN (LOGINADMIN) on delete restrict on update restrict;

alter table MESSAGE_ADMIN add constraint FK_RECEVOIR_MESSAGE_PROF foreign key (LOGINPROF)
      references PROFESSEUR (LOGINPROF) on delete restrict on update restrict;

alter table MESSAGE_MODULE add constraint FK_ENVOYER_MESSAGE_MODULE foreign key (LOGINPROF)
      references PROFESSEUR (LOGINPROF) on delete restrict on update restrict;

alter table MESSAGE_MODULE add constraint FK_RELATIF_A_MESSAGE foreign key (REFMODULE)
      references MODULE (REFMODULE) on delete restrict on update restrict;

alter table NOTER add constraint FK_NOTER foreign key (LOGINETU)
      references ETUDIANT (LOGINETU) on delete restrict on update restrict;

alter table NOTER add constraint FK_NOTER2 foreign key (INTITULEGROUPE, ANNEEGROUPE, REFMODULE, IDDEVOIR)
      references DEVOIR (INTITULEGROUPE, ANNEEGROUPE, REFMODULE, IDDEVOIR) on delete restrict on update restrict;

alter table PARTICIPER add constraint FK_PARTICIPER foreign key (INTITULEGROUPE, ANNEEGROUPE)
      references GROUPE (INTITULEGROUPE, ANNEEGROUPE) on delete restrict on update restrict;

alter table PARTICIPER add constraint FK_PARTICIPER2 foreign key (REFMODULE)
      references MODULE (REFMODULE) on delete restrict on update restrict;

alter table RECEVOIR add constraint FK_RECEVOIR foreign key (IDMESSAGE)
      references MESSAGE_MODULE (IDMESSAGE) on delete restrict on update restrict;

alter table RECEVOIR add constraint FK_RECEVOIR2 foreign key (INTITULEGROUPE, ANNEEGROUPE)
      references GROUPE (INTITULEGROUPE, ANNEEGROUPE) on delete restrict on update restrict;

alter table REPONDRE add constraint FK_REPONDRE foreign key (LOGINETU)
      references ETUDIANT (LOGINETU) on delete restrict on update restrict;

alter table REPONDRE add constraint FK_REPONDRE2 foreign key (IDSONDAGE)
      references SONDAGE (IDSONDAGE) on delete restrict on update restrict;

alter table SONDAGE add constraint FK_ENVOYER_SONDAGE foreign key (LOGINPROF)
      references PROFESSEUR (LOGINPROF) on delete restrict on update restrict;

alter table SONDAGE add constraint FK_RELATIF_A_SONDAGE foreign key (REFMODULE)
      references MODULE (REFMODULE) on delete restrict on update restrict;

