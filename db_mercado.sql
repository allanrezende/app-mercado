PGDMP      "            	    {            mercado    16.0    16.0 %               0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false                       0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false                       0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    32769    mercado    DATABASE     ~   CREATE DATABASE mercado WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Portuguese_Brazil.1252';
    DROP DATABASE mercado;
                postgres    false                        3079    41046    unaccent 	   EXTENSION     <   CREATE EXTENSION IF NOT EXISTS unaccent WITH SCHEMA public;
    DROP EXTENSION unaccent;
                   false                       0    0    EXTENSION unaccent    COMMENT     P   COMMENT ON EXTENSION unaccent IS 'text search dictionary that removes accents';
                        false    2            �            1259    41011    produto    TABLE     �   CREATE TABLE public.produto (
    id integer NOT NULL,
    nome character varying(255) NOT NULL,
    produto_tipo_id integer NOT NULL,
    valor numeric(12,2) NOT NULL,
    data_criacao timestamp with time zone NOT NULL
);
    DROP TABLE public.produto;
       public         heap    postgres    false            �            1259    41010    produto_id_seq    SEQUENCE     �   CREATE SEQUENCE public.produto_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.produto_id_seq;
       public          postgres    false    219                       0    0    produto_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.produto_id_seq OWNED BY public.produto.id;
          public          postgres    false    218            �            1259    41004    produto_tipo    TABLE     �   CREATE TABLE public.produto_tipo (
    id integer NOT NULL,
    nome character varying(255) NOT NULL,
    imposto_percentual numeric(7,2),
    data_criacao timestamp with time zone NOT NULL
);
     DROP TABLE public.produto_tipo;
       public         heap    postgres    false            �            1259    41003    produto_tipo_id_seq    SEQUENCE     �   CREATE SEQUENCE public.produto_tipo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.produto_tipo_id_seq;
       public          postgres    false    217                       0    0    produto_tipo_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.produto_tipo_id_seq OWNED BY public.produto_tipo.id;
          public          postgres    false    216            �            1259    41023    venda    TABLE     k   CREATE TABLE public.venda (
    id integer NOT NULL,
    data_criacao timestamp with time zone NOT NULL
);
    DROP TABLE public.venda;
       public         heap    postgres    false            �            1259    41022    venda_id_seq    SEQUENCE     �   CREATE SEQUENCE public.venda_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.venda_id_seq;
       public          postgres    false    221                       0    0    venda_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.venda_id_seq OWNED BY public.venda.id;
          public          postgres    false    220            �            1259    41030    venda_produto    TABLE     �   CREATE TABLE public.venda_produto (
    id integer NOT NULL,
    venda_id integer NOT NULL,
    produto_id integer NOT NULL,
    quantidade numeric(12,2) NOT NULL,
    valor_unitario numeric(12,2) NOT NULL,
    imposto_percentual numeric(7,2)
);
 !   DROP TABLE public.venda_produto;
       public         heap    postgres    false            �            1259    41029    venda_produto_id_seq    SEQUENCE     �   CREATE SEQUENCE public.venda_produto_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.venda_produto_id_seq;
       public          postgres    false    223                       0    0    venda_produto_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.venda_produto_id_seq OWNED BY public.venda_produto.id;
          public          postgres    false    222            g           2604    41057 
   produto id    DEFAULT     h   ALTER TABLE ONLY public.produto ALTER COLUMN id SET DEFAULT nextval('public.produto_id_seq'::regclass);
 9   ALTER TABLE public.produto ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    219    218    219            f           2604    41058    produto_tipo id    DEFAULT     r   ALTER TABLE ONLY public.produto_tipo ALTER COLUMN id SET DEFAULT nextval('public.produto_tipo_id_seq'::regclass);
 >   ALTER TABLE public.produto_tipo ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    216    217    217            h           2604    41059    venda id    DEFAULT     d   ALTER TABLE ONLY public.venda ALTER COLUMN id SET DEFAULT nextval('public.venda_id_seq'::regclass);
 7   ALTER TABLE public.venda ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    220    221    221            i           2604    41060    venda_produto id    DEFAULT     t   ALTER TABLE ONLY public.venda_produto ALTER COLUMN id SET DEFAULT nextval('public.venda_produto_id_seq'::regclass);
 ?   ALTER TABLE public.venda_produto ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    223    222    223                      0    41011    produto 
   TABLE DATA           Q   COPY public.produto (id, nome, produto_tipo_id, valor, data_criacao) FROM stdin;
    public          postgres    false    219   l(                 0    41004    produto_tipo 
   TABLE DATA           R   COPY public.produto_tipo (id, nome, imposto_percentual, data_criacao) FROM stdin;
    public          postgres    false    217   )       	          0    41023    venda 
   TABLE DATA           1   COPY public.venda (id, data_criacao) FROM stdin;
    public          postgres    false    221   �)                 0    41030    venda_produto 
   TABLE DATA           q   COPY public.venda_produto (id, venda_id, produto_id, quantidade, valor_unitario, imposto_percentual) FROM stdin;
    public          postgres    false    223   �)                  0    0    produto_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.produto_id_seq', 8, true);
          public          postgres    false    218                       0    0    produto_tipo_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.produto_tipo_id_seq', 48, true);
          public          postgres    false    216                       0    0    venda_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.venda_id_seq', 8, true);
          public          postgres    false    220                       0    0    venda_produto_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.venda_produto_id_seq', 22, true);
          public          postgres    false    222            m           2606    41016    produto produto_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.produto
    ADD CONSTRAINT produto_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.produto DROP CONSTRAINT produto_pkey;
       public            postgres    false    219            k           2606    41009    produto_tipo produto_tipo_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.produto_tipo
    ADD CONSTRAINT produto_tipo_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.produto_tipo DROP CONSTRAINT produto_tipo_pkey;
       public            postgres    false    217            o           2606    41028    venda venda_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.venda
    ADD CONSTRAINT venda_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.venda DROP CONSTRAINT venda_pkey;
       public            postgres    false    221            q           2606    41035     venda_produto venda_produto_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.venda_produto
    ADD CONSTRAINT venda_produto_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.venda_produto DROP CONSTRAINT venda_produto_pkey;
       public            postgres    false    223            r           2606    41017    produto produto_produto_tipo_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.produto
    ADD CONSTRAINT produto_produto_tipo_fk FOREIGN KEY (produto_tipo_id) REFERENCES public.produto_tipo(id);
 I   ALTER TABLE ONLY public.produto DROP CONSTRAINT produto_produto_tipo_fk;
       public          postgres    false    217    4715    219            s           2606    41041 &   venda_produto venda_produto_produto_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.venda_produto
    ADD CONSTRAINT venda_produto_produto_fk FOREIGN KEY (produto_id) REFERENCES public.produto(id);
 P   ALTER TABLE ONLY public.venda_produto DROP CONSTRAINT venda_produto_produto_fk;
       public          postgres    false    223    4717    219            t           2606    41036 $   venda_produto venda_produto_venda_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.venda_produto
    ADD CONSTRAINT venda_produto_venda_fk FOREIGN KEY (venda_id) REFERENCES public.venda(id);
 N   ALTER TABLE ONLY public.venda_produto DROP CONSTRAINT venda_produto_venda_fk;
       public          postgres    false    4719    223    221               �   x�m�1�0���`�.�뵴݌����K%(F�	A��� ��/�=���ĂE"`bSj*��D�Qm�*�vD��!�3��B
"^&��)�w����0k:�E��v~�d�T��Oˣ[YF�v����pL�5��87����������*�~
]6+         {   x�e�;
1 �zr
{�a~	�����M� Z(���u���2f��1��@HtaZDw��j3��J�{�d��׼0�R8S�u)ʺq�>�6A*��,(�<o֡_�#����E���)�7sY&y      	   F   x�]ɹ�0�UA�أ;��jq�u0ʀM�tF�Ɖ&.uF��n�ݤ0��1>��̘�X
����n8�         @   x�m̱�0C�Z�C�K��#�vݿWH�	�;���g���Bl�=Z���`A����5��k     