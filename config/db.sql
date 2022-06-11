create table usuarios(
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
  coins int(11) not null default 0,
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `usuarios_conquistas` (
  `id` int primary key auto_increment NOT NULL,
  `usuario` int(11) not null,
  `conquista` int not null,
  foreign key(usuario) references usuarios(id),
  foreign key(conquista) references conquista(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `conquistas` (
  `id` int primary key auto_increment NOT NULL,
  `nome` varchar(255) not null,
  `premio_coins` int(11) not null  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `conquistas`(nome, premio_coins) VALUES
('Primeiro comentário', 10), ('Login diário', 10), ('Primeiro comentário em timeline', 5), ('Primeira timeline', 15);

create table noticias(
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

create table noticias_comentarios(
  id int primary key auto_increment not null,
  id_noticia int not null,
  autor varchar(20) not null,
  comentario mediumtext not null,
  data int not null
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

create table noticias_cat(
  id int primary key auto_increment not null,
  nome varchar(255) not null,
  icone varchar(255) not null,
  status enum('ativo', 'inativo')
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

create table forum(
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
  ip varchar(255) not null
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE pixel (
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

CREATE TABLE `pixel_comentarios` (
  `id` int(11) primary key auto_increment NOT NULL,
  `id_pixel` int(11) NOT NULL,
  `autor` varchar(20) NOT NULL,
  `comentario` mediumtext NOT NULL,
  `data` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

create table pixel_cat(
  id int primary key auto_increment not null,
  nome varchar(255) not null,
  icone varchar(255) not null,
  status enum('ativo', 'inativo')
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE `forum_comentarios` (
  `id` int(11) primary key auto_increment NOT NULL,
  `id_forum` int(11) NOT NULL,
  `autor` varchar(20) NOT NULL,
  `comentario` mediumtext NOT NULL,
  `data` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `compraveis` (
  `id` int primary key auto_increment NOT NULL,
  `nome` varchar(255) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `valor` float NOT NULL,
  `promocao` enum('sim', 'nao') NOT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

insert into `compraveis`(nome, tipo, valor, promocao, imagem) values('Espelhin', 'mobi', 300, 'nao', '');

insert into noticias(titulo, resumo, categoria, imagem, criador, url, texto, revisado, data, status, visualizacao, dia_evento, data_evento) 
values('Receba noticia teste', 'Ja testou?', 1, '', 'geefi', 'nao tenho ctz', 'opa esta é uma super noticia de qualdade duvidosa', '', '1649961316', 'ativo', '', '', '');

insert into noticias_comentarios(id_noticia, autor, comentario, data)
values(1, 'geefi', 'Os comentários tbm funcionam, já testou?', 1649511402);

insert into noticias_cat(nome, icone, status) values('Moda', '', 'ativo');

insert into pixel_cat(nome, icone, status) values
('Logotipo', '', 'ativo'),('Tirinha', '', 'ativo'),('Emoticon', '', 'ativo'),('Emblema', '', 'ativo'),('Webdesign', '', 'ativo'),('Banners', '', 'ativo'),
('Avatar', '', 'ativo'),('Assinatura', '', 'ativo'),('Outras artes', '', 'ativo');