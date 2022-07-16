create database if not exists habbletxd character set utf8mb4 collate utf8mb4_ja_0900_as_cs;
use habbletxd;
create table if not exists usuarios(
  id int(11) auto_increment primary key not null,
  usuario varchar(255) not null,
  senha varchar(255) not null,
  email varchar(255) not null,
  ultimo_data int(255) not null,
  ultimo_ip varchar(255) not null,
  dia_register varchar(255) not null,
  banido enum('nao', 'sim') not null,
  confirmado enum('nao', 'sim') not null,
  assinatura mediumtext not null,
  missao varchar(255) not null,
  twitter varchar(255) default '@UniaoHabbo' not null,
  presenca int(255) not null,
  avatar varchar(255) default 'uploads/avatar.png',
  coins int(11) not null default 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE if not exists `usuarios_conquistas` (
  `id` int primary key auto_increment NOT NULL,
  `usuario` int(11) not null,
  `conquista` int not null,
  foreign key(usuario) references usuarios(id),
  foreign key(conquista) references conquista(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE if not exists `conquistas` (
  `id` int primary key auto_increment NOT NULL,
  `nome` varchar(255) not null,
  `premio_coins` int(11) not null  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

create table if not exists noticias(
  id int (11) primary key auto_increment not null,
  titulo varchar(255) not null,
  resumo varchar(255) not null,
  categoria varchar(255) not null,
  imagem varchar(255) not null,
  criador varchar(255) not null,
  revisado varchar(255) not null,
  data varchar(255) not null,
  status varchar(255) not null,
  url varchar(255) not null,
  texto mediumtext not null,
  visualizacao varchar(255) not null,
  evento enum('sim', 'nao') not null,
  dia_evento varchar(255) not null,
  data_evento varchar(255) not null,
  fixo enum('sim', 'nao') not null
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

create table if not exists noticias_comentarios(
  id int primary key auto_increment not null,
  id_noticia int not null,
  autor varchar(20) not null,
  comentario mediumtext not null,
  data int not null
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

create table if not exists noticias_cat(
  id int primary key auto_increment not null,
  nome varchar(255) not null,
  icone varchar(255) not null,
  status enum('ativo', 'inativo')
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

create table if not exists forum(
  id int primary key auto_increment not null,
  titulo varchar(255) not null,
  categoria varchar(255) not null,
  autor varchar(255) not null,
  texto mediumtext not null,
  data varchar(255) not null,
  reviver int(255) not null,
  moderado varchar(255) not null,
  moderador varchar(255) not null,
  url varchar(255) not null,
  fixo enum('sim', 'nao') not null,
  status enum('ativo', 'inativo') not null,
  ip varchar(255) not null,
  visualizacao int not null,
  likes int not null
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE forum_likes(
  id int(11) primary key auto_increment not null,
  usuario_id int not null,
  forum_url varchar(255) not null
);

CREATE TABLE noticias_likes(
  id int(11) primary key auto_increment not null,
  usuario_id int not null,
  noticia_url varchar(255) not null
);

CREATE TABLE pixel_likes(
  id int(11) primary key auto_increment not null,
  usuario_id int not null,
  pixel_url varchar(255) not null
);

CREATE TABLE if not exists pixel (
  id int(11) primary key auto_increment NOT NULL,
  titulo varchar(255) NOT NULL,
  categoria int(11) NOT NULL,
  descricao varchar(255) NOT NULL,
  imagem varchar(255) NOT NULL,
  autor varchar(255) NOT NULL,
  data varchar(255) NOT NULL,
  url varchar(255) NOT NULL,
  status enum('sim','nao') NOT NULL DEFAULT 'nao',
  width varchar(255) NOT NULL,
  height varchar(255) NOT NULL,
  ip varchar(255) NOT NULL,
  tirinha enum('nao','sim') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE if not exists `pixel_comentarios` (
  `id` int(11) primary key auto_increment NOT NULL,
  `id_pixel` int(11) NOT NULL,
  `autor` varchar(20) NOT NULL,
  `comentario` mediumtext NOT NULL,
  `data` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

create table if not exists pixel_cat(
  id int primary key auto_increment not null,
  nome varchar(255) not null,
  icone varchar(255) not null,
  status enum('ativo', 'inativo')
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE if not exists `forum_comentarios` (
  `id` int(11) primary key auto_increment NOT NULL,
  `id_forum` int(11) NOT NULL,
  `autor` varchar(20) NOT NULL,
  `comentario` mediumtext NOT NULL,
  `data` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE if not exists `compraveis` (
  `id` int primary key auto_increment NOT NULL,
  `nome` varchar(255) NOT NULL,
  `tipo` enum('emblema', 'mobi', 'raro', 'visual') NOT NULL,
  `valor` float NOT NULL,
  `promocao` enum('sim', 'nao') NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `gratis` enum('sim', 'nao') NOT NULL,
  `data` int(11) NOT NULL
);

CREATE TABLE `valores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_ja_0900_as_cs NOT NULL,
  `categoria` int NOT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_ja_0900_as_cs NOT NULL,
  `preco` varchar(255) COLLATE utf8mb4_ja_0900_as_cs NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_ja_0900_as_cs NOT NULL,
  `moeda` varchar(255) not null,
  `situacao` enum('Em alta', 'Estável', 'Baixa') not null,
  `valorltd` varchar(255) not null,
  PRIMARY KEY (`id`),
  KEY `fk_cat` (`categoria`),
  CONSTRAINT `fk_cat` FOREIGN KEY (`categoria`) REFERENCES `valores_cat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_ja_0900_as_cs;

CREATE TABLE IF NOT EXISTS presenca(
  id int(11) primary key auto_increment not null,
  codigo varchar(255) not null,
  ativo varchar(255) not null,
  data varchar(255) not null,
  criador varchar(255) not null
);

CREATE TABLE IF NOT EXISTS presenca_usado(
  id int(11) primary key auto_increment not null,
  id_cod varchar(255) not null,
  usuario varchar(255) not null,
  data int(11) not null
);

CREATE TABLE IF NOT EXISTS forum_hashtags(
  id int primary key auto_increment not null,
  usuario varchar(255) not null,
  tag varchar(255) not null,
  data varchar(255) not null
);

CREATE TABLE IF NOT EXISTS usuarios_comprados(
  id int primary key auto_increment not null,
  usuario varchar(255) not null,
  item int not null
);

CREATE TABLE IF NOT EXISTS emblemas(
  id int primary key auto_increment not null,
  nome varchar(255) not null,
  imagem varchar(255) not null,
  tutorial varchar(255) null,
  gratis enum('sim', 'nao') not null,
  conquistado varchar(255) null,
  usuarios_qtd int null,
  codigo varchar(255) null
);

ALTER TABLE usuarios_comprados ADD CONSTRAINT fk_item FOREIGN KEY(item) REFERENCES compraveis(id);

alter table usuarios add column ultimo_dia varchar(255) not null;

insert into forum(titulo, categoria, autor, texto, data, reviver, moderado, moderador, url, fixo, status, ip) values(
  'Primeira timeline!',
  'timeline',
  'geefi',
  'Oieee esta é a primeira timeline do site uau',
  '1650066187',
  1650066120,
  'nao',
  '',
  '',
  'nao',
  'ativo',
  '192.168.0.1'
);

alter table forum add column hashtags varchar(255) null;

insert into `compraveis`(nome, tipo, valor, promocao, imagem, gratis, data) values('mergulhando', 'emblema', 300, 'nao', '', 'sim', 1650066187);

insert into noticias(titulo, resumo, categoria, imagem, criador, url, texto, revisado, data, status, visualizacao, dia_evento, data_evento) 
values('Receba noticia teste', 'Ja testou?', 1, '', 'geefi', 'nao tenho ctz', 'opa esta é uma super noticia de qualdade duvidosa', '', '1649961316', 'ativo', '', '', '');

insert into noticias_comentarios(id_noticia, autor, comentario, data)
values(1, 'geefi', 'Os comentários tbm funcionam, já testou?', 1649511402);

insert into noticias_cat(nome, icone, status) values
('Arquitetos', 'category_icon_architects.png', 'ativo'), ('Campanhas', 'category_icon_compaigns.png', 'ativo'), ('Competições', 'category_icon_competitions.png', 'ativo'),
('Eventos', 'category_icon_events.png', 'ativo'), ('Externas', 'category_icon_externas.png', 'ativo'), ('Fan sites', 'category_icon_fansites.png', 'ativo'),
('Coisas gratis', 'category_icon_freestuff.png', 'ativo'), ('HabbletXD', 'category_icon_habbletxd.gif', 'ativo'), ('Habbo hotel', 'category_icon_habbohotel.png', 'ativo'),
('Novidades', 'category_icon_news.gif', 'ativo'), ('Reportagens', 'category_icon_reports.png', 'ativo');

insert into pixel_cat(nome, icone, status) values
('Logotipo', '', 'ativo'),('Tirinha', '', 'ativo'),('Emoticon', '', 'ativo'),('Emblema', '', 'ativo'),('Webdesign', '', 'ativo'),('Banners', '', 'ativo'),
('Avatar', '', 'ativo'),('Assinatura', '', 'ativo'),('Outras artes', '', 'ativo');

INSERT INTO `conquistas`(id, nome, premio_coins) VALUES
('Primeiro comentário', 10), ('Login diário', 10), ('Primeiro comentário em timeline', 5), ('Primeira timeline', 15), (5, 'Primeira arte', 10);

INSERT INTO `valores_cat`(nome, imagem) values('Raro de pack', ''),('Raro de staff', ''),('Raro LTD', ''),('Raro de evento', '');


INSERT INTO usuarios_emblemas(usuario, emblema) VALUES(?, ?);

alter table valores add column icone varchar(255) not null;

CREATE TABLE noticias_lidos(
  id int primary key auto_increment not null,
  usuario int not null,
  noticia_lida varchar(255) not null
);

CREATE TABLE usuarios_destaquesxd(
  id int primary key auto_increment not null,
  usuario varchar(255) not null,
  motivo text not null,
  key `fk_destacado` (usuario),
  CONSTRAINT `fk_destacado` FOREIGN KEY (usuario) REFERENCES usuarios(usuario)
) ENGINE=MyISAM AUTO_INCREMENT=383 DEFAULT CHARSET=utf8mb3;

CREATE TABLE index_carousel(
  id int primary key auto_increment not null,
  imagem varchar(255) not null
);

ALTER TABLE usuarios ADD COLUMN artigo_delay varchar(255) not null;
