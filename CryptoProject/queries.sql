--
-- PostgreSQL database dump
--

-- Dumped from database version 13.4
-- Dumped by pg_dump version 13.4

-- Started on 2022-07-22 20:19:59

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 209 (class 1259 OID 57516)
-- Name: blockchain; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.blockchain (
    unique_id integer NOT NULL,
    sender character varying,
    receiver character varying,
    no_of_coins integer,
    coin_name character varying
);


ALTER TABLE public.blockchain OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 57514)
-- Name: blockchain_unique_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.blockchain ALTER COLUMN unique_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.blockchain_unique_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 200 (class 1259 OID 32779)
-- Name: cryptocurrencies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cryptocurrencies (
    coin_name character varying(10) NOT NULL,
    cname character varying(20) NOT NULL,
    crank integer NOT NULL,
    price real NOT NULL,
    _24hr real NOT NULL,
    _7d real NOT NULL
);


ALTER TABLE public.cryptocurrencies OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 32810)
-- Name: exchangeslist; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.exchangeslist (
    elname character varying(50) NOT NULL,
    elrank integer NOT NULL,
    basedin character varying(20) NOT NULL,
    regulated character varying(10) NOT NULL,
    founded character varying(20) NOT NULL,
    tradecommper real NOT NULL,
    exchangescr real NOT NULL
);


ALTER TABLE public.exchangeslist OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 32815)
-- Name: exchangeslist_price; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.exchangeslist_price (
    elname character varying(50),
    coin_name character varying(10) NOT NULL,
    price real,
    no_of_coins integer
);


ALTER TABLE public.exchangeslist_price OWNER TO postgres;

--
-- TOC entry 207 (class 1259 OID 57498)
-- Name: temp_blockchain; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.temp_blockchain (
    unique_id integer NOT NULL,
    sender character varying,
    receiver character varying,
    no_of_coins integer,
    coin_name character varying
);


ALTER TABLE public.temp_blockchain OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 57496)
-- Name: temp_blockchain_unique_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.temp_blockchain ALTER COLUMN unique_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.temp_blockchain_unique_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 205 (class 1259 OID 57464)
-- Name: user_assets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_assets (
    username character varying,
    coin_name character varying,
    no_of_coins integer,
    source character varying
);


ALTER TABLE public.user_assets OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 57381)
-- Name: user_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_details (
    id integer NOT NULL,
    username character varying NOT NULL,
    email character varying,
    password character varying
);


ALTER TABLE public.user_details OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 57379)
-- Name: user_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.user_details ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.user_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 3035 (class 0 OID 57516)
-- Dependencies: 209
-- Data for Name: blockchain; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.blockchain (unique_id, sender, receiver, no_of_coins, coin_name) FROM stdin;
1	Kishore Prashanth	aaa	1	SHIB
2	Kishore Prashanth	aaa	1	ETH
3	aaa	Kishore Prashanth	1	ETH
4	Kishore Prashanth	Prithysha	1	SHIB
5	aaa	Prithysha	1	SHIB
6	qwe	Kishore Prashanth	1	ETH
7	Kishore Prashanth	aaa	1	ETH
8	Kishore Prashanth	mno	1	SOL
9	mno	Kishore Prashanth	1	ETH
\.


--
-- TOC entry 3026 (class 0 OID 32779)
-- Dependencies: 200
-- Data for Name: cryptocurrencies; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cryptocurrencies (coin_name, cname, crank, price, _24hr, _7d) FROM stdin;
BTC	Bitcoin	1	63148.95	3.31	4.04
ETH	Ethereum	2	4584.05	5.94	8.67
BNB	Binance Coin	3	548.97	0.2	13.25
USDT	Tether	4	1	0.05	0.11
SOL	Solana	5	227.71	11.26	11.04
XRP	XRP	7	1.16	8.2	8.14
DOT	Polkadot	8	50.15	0.77	11.04
DOGE	Dogecoin	10	0.2722	0.56	4.01
ADA	Cardano	6	1.96	0.51	-8.67
SHIB	SHIBA INU	9	0.0006	-5.68	24.04
\.


--
-- TOC entry 3027 (class 0 OID 32810)
-- Dependencies: 201
-- Data for Name: exchangeslist; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.exchangeslist (elname, elrank, basedin, regulated, founded, tradecommper, exchangescr) FROM stdin;
Binance	1	USA	Yes	Sep 2019	0.1	9.8
Coinbase Exchange	2	USA	Yes	May 2014	1.49	8.9
KuCoin	3	Singapore	No	Sep 2017	0.1	8.5
FTX	4	Bahamas	Yes	Sep 2017	0.1	8.5
Gate.io	5	Kentuchy	No	April 2013	0.075	8.4
Kraken	6	USA	Yes	July 2011	0.26	8.4
\.


--
-- TOC entry 3028 (class 0 OID 32815)
-- Dependencies: 202
-- Data for Name: exchangeslist_price; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.exchangeslist_price (elname, coin_name, price, no_of_coins) FROM stdin;
Kraken	BNB	558.64	20
Coinbase Exchange	SHIB	0.0006	15
KuCoin	SHIB	0.0006	15
FTX	SHIB	0.0006	15
Binance	XRP	1.2	4
Kraken	BTC	61609.8	29
Kraken	ETH	4518.02	24
Kraken	SHIB	0.0006	14
FTX	BTC	61626	29
Gate.io	BTC	61691.16	28
Binance	ETH	4511.56	25
KuCoin	ETH	4529.55	25
Gate.io	ETH	4522.18	25
Coinbase Exchange	BNB	559.81	20
KuCoin	BNB	559.56	20
FTX	BNB	558.74	20
Gate.io	BNB	558.84	20
Binance	USDT	1	7
Coinbase Exchange	USDT	1	7
KuCoin	USDT	0.9997	7
FTX	USDT	1	7
Kraken	USDT	1	7
Binance	SOL	238.38	10
Coinbase Exchange	SOL	240.5	10
KuCoin	SOL	240.11	10
FTX	SOL	241.1	10
Kraken	SOL	240.53	10
Binance	ADA	2.069	12
Coinbase Exchange	ADA	2.03	12
KuCoin	ADA	2.03	12
FTX	ADA	2.01	12
Gate.io	ADA	2.02	12
Kraken	ADA	2.01	12
Coinbase Exchange	XRP	1.2	5
KuCoin	XRP	1.19	5
FTX	XRP	1.2	5
Gate.io	XRP	1.2	5
Kraken	XRP	1.19	5
Binance	DOT	52.87	4
Coinbase Exchange	DOT	52.67	4
KuCoin	DOT	52.7	4
FTX	DOT	42.35	4
Gate.io	DOT	53.111	4
Kraken	DOT	52.75	4
FTX	DOGE	0.2633	9
Kraken	DOGE	0.2623	9
Binance	BNB	551.43	19
Binance	SHIB	0.0006	16
Coinbase Exchange	BTC	61633.06	28
Gate.io	SHIB	0.0006	15
FTX	ETH	4522.1	23
KuCoin	DOGE	0.2632	3
Binance	DOGE	0.2636	4
Coinbase Exchange	ETH	4525.21	22
Coinbase Exchange	DOGE	0.2634	15
Gate.io	USDT	0.85748	7
Gate.io	SOL	241.36	9
KuCoin	BTC	61660.49	24
Gate.io	DOGE	0.2632	8
Binance	BTC	61692.45	20
\.


--
-- TOC entry 3033 (class 0 OID 57498)
-- Dependencies: 207
-- Data for Name: temp_blockchain; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.temp_blockchain (unique_id, sender, receiver, no_of_coins, coin_name) FROM stdin;
11	mno	Kishore Prashanth	1	SOL
\.


--
-- TOC entry 3031 (class 0 OID 57464)
-- Dependencies: 205
-- Data for Name: user_assets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_assets (username, coin_name, no_of_coins, source) FROM stdin;
Prithysha	SHIB	1	Mining Reward
aaa	BNB	1	Exchange Platform
Prithysha	SHIB	1	Credited
aaa	ETH	1	Credited
Prithysha	ETH	1	Mining Reward
qwe	ETH	6	Exchange Platform
qwe	SOL	1	Mining Reward
Kishore Prashanth	ETH	1	Credited
qwe	ETH	1	Mining Reward
qwe	DOGE	6	Exchange Platform
qwe	BTC	14	Exchange Platform
\.


--
-- TOC entry 3030 (class 0 OID 57381)
-- Dependencies: 204
-- Data for Name: user_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_details (id, username, email, password) FROM stdin;
1	Kishore Prashanth	kishorep3105@gmail.com	6702e858b80ba8df8ce576eb2ca09734
3	kp	kp@gmail.com	698d51a19d8a121ce581499d7b701668
4	aaa	aaa@gmail.com	698d51a19d8a121ce581499d7b701668
5	Prithysha	prithysha@gmail.com	7ddf94d0bb74568b83f8b55066cf7d81
7	qwe	qwe@gmail.com	76d80224611fc919a5d54f0ff9fba446
8	mno	mno@gmail.com	d1cf6a6090003989122c4483ed135d55
9	testA	testA@gmail.com	a7291eec016a1ca4c3abd1b531845009
10	testB	testB@gmail.com	e519d2744a05dc4445b6c88dae28eb74
\.


--
-- TOC entry 3041 (class 0 OID 0)
-- Dependencies: 208
-- Name: blockchain_unique_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.blockchain_unique_id_seq', 9, true);


--
-- TOC entry 3042 (class 0 OID 0)
-- Dependencies: 206
-- Name: temp_blockchain_unique_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.temp_blockchain_unique_id_seq', 12, true);


--
-- TOC entry 3043 (class 0 OID 0)
-- Dependencies: 203
-- Name: user_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_details_id_seq', 10, true);


--
-- TOC entry 2883 (class 2606 OID 32783)
-- Name: cryptocurrencies coin_name_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cryptocurrencies
    ADD CONSTRAINT coin_name_pk PRIMARY KEY (coin_name);


--
-- TOC entry 2885 (class 2606 OID 32814)
-- Name: exchangeslist elname_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exchangeslist
    ADD CONSTRAINT elname_pk PRIMARY KEY (elname);


--
-- TOC entry 2887 (class 2606 OID 57388)
-- Name: user_details user_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_details
    ADD CONSTRAINT user_details_pkey PRIMARY KEY (username);


--
-- TOC entry 2895 (class 2606 OID 57527)
-- Name: blockchain blockchain_receiver_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.blockchain
    ADD CONSTRAINT blockchain_receiver_fkey FOREIGN KEY (receiver) REFERENCES public.user_details(username);


--
-- TOC entry 2894 (class 2606 OID 57522)
-- Name: blockchain blockchain_sender_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.blockchain
    ADD CONSTRAINT blockchain_sender_fkey FOREIGN KEY (sender) REFERENCES public.user_details(username);


--
-- TOC entry 2888 (class 2606 OID 32818)
-- Name: exchangeslist_price coin_name_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exchangeslist_price
    ADD CONSTRAINT coin_name_fk FOREIGN KEY (coin_name) REFERENCES public.cryptocurrencies(coin_name);


--
-- TOC entry 2889 (class 2606 OID 32823)
-- Name: exchangeslist_price elname_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exchangeslist_price
    ADD CONSTRAINT elname_fk FOREIGN KEY (elname) REFERENCES public.exchangeslist(elname);


--
-- TOC entry 2893 (class 2606 OID 57509)
-- Name: temp_blockchain temp_blockchain_receiver_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temp_blockchain
    ADD CONSTRAINT temp_blockchain_receiver_fkey FOREIGN KEY (receiver) REFERENCES public.user_details(username);


--
-- TOC entry 2892 (class 2606 OID 57504)
-- Name: temp_blockchain temp_blockchain_sender_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temp_blockchain
    ADD CONSTRAINT temp_blockchain_sender_fkey FOREIGN KEY (sender) REFERENCES public.user_details(username);


--
-- TOC entry 2891 (class 2606 OID 57475)
-- Name: user_assets user_assets_coin_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_assets
    ADD CONSTRAINT user_assets_coin_name_fkey FOREIGN KEY (coin_name) REFERENCES public.cryptocurrencies(coin_name);


--
-- TOC entry 2890 (class 2606 OID 57470)
-- Name: user_assets user_assets_username_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_assets
    ADD CONSTRAINT user_assets_username_fkey FOREIGN KEY (username) REFERENCES public.user_details(username);


-- Completed on 2022-07-22 20:20:02

--
-- PostgreSQL database dump complete
--

