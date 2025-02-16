# AdrexM
Acesta este un proiect baza de date cu interfata web ce va avea ca scop functionalitatile indicate mai jos 
Legenda: 
  (+) - Deja realizat
  (+/-) - Partial realizat
  (-) - In curs de realizare 

1. Cerințe generale:
Aplicația va permite gestionarea echipamentelor/materialelor între depozite și transferul acestora către clienți sau persoane desemnate. (+)
Gestionarea și urmărirea echipamentelor va include detalii precum număr de serie, MAC, locație, configurație, etc. (+)
Aplicația va avea mai multe nivele de acces: Admin, SuperUser și utilizatori obișnuiți.(+)
Datele vor fi salvate într-o bază de date pentru fiecare etapă a managementului.(+)
2. Structura aplicației:
Aplicația va fi împărțită în următoarele module principale:

2.1 Autentificare și autorizare
Pagina de logare pentru utilizatori, inclusiv SuperUser și Admin.(+)
Autentificare pe bază de roluri:
SuperUser: are acces complet la toate funcționalitățile aplicației (creare conturi noi, ștergere date, modificare drepturi).(+)
Admin: poate gestiona datele despre echipamente, clienți și rapoarte. (+/-)
Utilizatori de rând: pot vizualiza date și adăuga informații legate de activitățile curente (depozitare/transfer echipamente). (+)
Autorizare pe baza rolului: Controlul accesului pentru diverse funcționalități va fi bazat pe roluri (e.g., doar Admin și SuperUser pot edita bazele de date). (+)
2.2 Dashboard și administrare:
Pagina principală pentru Admin și SuperUser:
Vedere generală a depozitelor: statusul fiecărui depozit (număr echipamente, disponibilitate, stoc).(+)
Istoricul (log) transferurilor: un log cu toate transferurile de echipamente între depozite și către clienți. (-)
Raportare: statistici despre mișcările echipamentelor, echipamente defecte, configurații speciale. (+/-)
Setări și management de conturi (doar pentru SuperUser). (+)
2.3 Gestionare echipamente și transferuri:
Primire/predare echipamente/materiale între depozite: (+)
Se va folosi un cod unic de identificare (de exemplu: număr de serie sau cod QR pentru scanare rapidă). (+)
Fiecare transfer (log) va fi însoțit de detalii precum: cine a realizat transferul, data și ora, statusul echipamentului. (-)
Transmitere echipament către o persoană anume:
Atribuirea unui echipament către un client specific (nume, locație, etc.). (+)
Detalii despre locul unde a fost instalat echipamentul și cine a realizat montajul. (+/-)
Salvare detalii echipament:
Număr de serie, MAC, data instalării, locația exactă (cu posibilitate de a include coordonate GPS), detalii despre configurare. (+)
2.4 Baza de date și gestiune date:
Managementul bazei de date:
Bază de date pentru echipamente: detalii despre fiecare echipament (model, număr de serie, MAC, status, locație curentă, configurare). (+)
Bază de date clienți: fiecare client va avea un profil cu informații personale, locația unde au fost instalate echipamentele și istoricul echipamentelor asociate. (+)
Bază de date pentru utilizatori: date despre Admin, SuperUser și utilizatori obișnuiți (roluri și drepturi de acces). (+)
2.5 Configurarea echipamentelor:
Pentru echipamentele care necesită configurare suplimentară (ex: echipamente de rețea), aplicația va include o secțiune unde se pot înregistra și salva detalii despre setările efectuate (ex: IP, parole de acces, alte setări tehnice). (+)
2.6 Rapoarte și export de date:
Generare de rapoarte despre activitatea depozitului și echipamente: (?)
Transferuri între depozite. (+)
Configurații și actualizări ale echipamentelor. (+)
Rapoarte lunare pentru echipamente defecte sau lipsă. (?)
Export date în diverse formate (CSV, PDF) pentru a putea trimite sau arhiva informațiile.  (?)