# Ipotesi A: refactoring completo

Revisione completa dei processi al di fuori della piattaforma IBM i



## Applicazione Lista Pre-ordini 

```mermaid
sequenceDiagram
    actor ut as Utente
    participant ph as PHP
    participant nd as Node.js
    participant ms as MySql 
    participant wl as WexLog
    ut->>ph: Login 
    ph->>ph: Generazione Token JWT 
    ph-->>ut: Token JWT 
    ut->>nd: Interrogazione Pre-Ordini (JWT)
    nd->>nd: Validazione Token JWT  
    nd->>ms: Leggi Pre-ordini
    ms-->>nd: dati
    nd-->>ut: Elenco Pre-ordini
    ut->>nd: Seleziona pre-ordini 
    nd->>wl: Conferma Invio Pre-Ordine via API
    wl-->>nd: ok
```


## Flow 1: Customer Data Reception and save in customer Specific Tables and ODS


```mermaid
sequenceDiagram
    participant ka as Kafka
    participant ms as MySql 
    participant wa as WebApp

    ka->>ms: Ricezione messaggi Kafka
    ms->>wa: Scrittura messaggi CSD
    wa->>wa: Elaborazione tabelle CSD pre-order 
    wa->>wa: Procedura DB2 di ODS dogana
    wa->>wa: Procedura DB2 di ODS dogana
```

## Flow 2


```mermaid
sequenceDiagram
    participant ms as MySql 
    participant wa as WebApp (PHP)
    participant as as AS400
    participant mq as ACTIVEMQ
    participant gc as Gestionale Cliente
    as->>mq: alimentazione coda messaggi 
    mq->>wa: ricezione messaggi 
    wa->>gc: invio notifiche email
```

## Flow 3 

```mermaid
sequenceDiagram
    actor ut as Utente
    participant wa as WebApp
    participant ms as MySql 
    participant wl as WexLog
    ut->>wa: Interrogazione Pre-Ordini
    wa->>ms: Leggi Pre-ordini
    ms-->>wa: dati
    wa-->>ut: Elenco Pre-ordini
    ut->>wa: Seleziona pre-ordini 
    wa->>wl: Conferma Invio Pre-Ordine via API
    wl-->>wa: ok
```


# Ipotesi B: Revisione parziale 

Revisione parziale dei processi cercando di conservare l’as-is al fine di contenere l’effort di sviluppo

## Flow 1: Customer Data Reception and save in customer Specific Tables and ODS


```mermaid
sequenceDiagram
    participant ka as Kafka
    participant wa as Linux WebApp 
    participant as as AS400 TMS

    ka->>wa: Ricezione messaggi Kafka
    wa->>as: Scrittura messaggi CSD
    as->>as: Elaborazione tabelle CSD 
    as->>as: Procedura elaborazione Buffer
    as->>as: Procedura ODS per pre-order

```


## Flow 2

Fill-in AS400 Data Queue in order to send back data to customer 

```mermaid
sequenceDiagram
    participant wa as WebApp (PHP)
    participant as as AS400
    participant mq as ACTIVEMQ
    participant gc as Gestionale Cliente
    as->>mq: alimentazione coda mesaggi 
    mq->>wa: ricezione messaggi 
    wa->>gc: invio notifiche email
```



