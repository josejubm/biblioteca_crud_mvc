/* tables */
CREATE TABLE `users` 
(
  `id`  INT(5) NOT NULL AUTO_INCREMENT,
  `user`    VARCHAR(20) NOT NULL,
  `password`   VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE = InnoDB;
INSERT INTO `users` (`id`, `user`, `password`) 
              VALUES ('1', 'jose', '1234'); 
CREATE TABLE `usuarios` 
(
  `ClaveUsu`  VARCHAR(11) NOT NULL,
  `Nombre`    VARCHAR(20) NOT NULL,
  `Paterno`   VARCHAR(20) NOT NULL,
  `Materno`   VARCHAR(20) NULL,
  `Colonia`   VARCHAR(50) NOT NULL,
  `Calle`     VARCHAR(50) NOT NULL,
  `Numero`    VARCHAR(10) NOT NULL,
  `Telefono`  VARCHAR(10) NOT NULL,
  PRIMARY KEY (`ClaveUsu`)
)ENGINE = InnoDB;



CREATE TABLE `editoriales` 
(
  `Id`      INT(2) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Id`)
)ENGINE = InnoDB;



CREATE TABLE `libros`
 (
  `ISBN`        VARCHAR(17) NOT NULL,
  `Titulo`      VARCHAR(50) NOT NULL,
  `editorial_Id` INT(2) NOT NULL,
  PRIMARY KEY (`ISBN`),
  CONSTRAINT `fk_libros_editoriales1` FOREIGN KEY (`editorial_Id`) REFERENCES `adb_2023_act6_Bmanuel`.`editoriales` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
  )ENGINE = InnoDB;



CREATE TABLE `prestamos` 
(
  `Salida`     DATE NULL,
  `Devolucion` DATE NULL,
  `ClaveUsu`   VARCHAR(11) NOT NULL,
  `ISBN`       VARCHAR(17) NOT NULL,
  CONSTRAINT `fk_prestamo_usuarios`FOREIGN KEY (`ClaveUsu`)REFERENCES `adb_2023_act6_Bmanuel`.`usuarios` (`ClaveUsu`)ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_prestamo_libros1` FOREIGN KEY (`ISBN`)    REFERENCES `adb_2023_act6_Bmanuel`.`libros`    (`ISBN`)   ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE = InnoDB;



CREATE TABLE `autores` 
(
  `Id` INT(2) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(20) NOT NULL,
  `Paterno` VARCHAR(20) NOT NULL,
  `Materno` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`Id`)
)ENGINE = InnoDB;



CREATE TABLE `libros_autores` 
(
  `ISBN` VARCHAR(17) NOT NULL,
  `autor_Id` INT(2)  NOT NULL,
  UNIQUE KEY(`ISBN`,`autor_Id`),
  CONSTRAINT `fk_libros_autor_libros1` FOREIGN KEY (`ISBN`) REFERENCES `adb_2023_act6_Bmanuel`.`libros` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_libros_autor_autores1`  FOREIGN KEY (`autor_Id`)REFERENCES `adb_2023_act6_Bmanuel`.`autores` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE = InnoDB;


/* inserts */



INSERT INTO `usuarios` (`ClaveUsu`,     `Nombre`,   `Paterno`,  `Materno`,   `Colonia`,                 `Calle`,                        `Numero`,  `Telefono`   ) VALUES
                       ('1889162',      'Eduardo',   'Sureda',   'Escalona',  'Juárez',                  '11 De Mayo',                   '#1261',  '7569057023' ),
                       ('1761521',      'Martín',    'Arnau',    'Cañellas',  'Lomas De Vista Hermosa',  '11 Norte',                     '#3165',  '7568208562' ),
                       ('1851859',      'Albina',    'Meza',     'Arana',     'Polanco',                 '11 Poniente',                  '#4758',  '7560690127' ),
                       ('1772483',      'Vilma',     'Vizcaíno', 'Almeida',   'Tlatelolco',              '11 Sur',                       '#3940',  '7566647179' ),
                       ('1257998',      'Juanito',   'Arteaga',  'Sáez',      'Del Carmen',              '12 De Octubre',                '#1996',  '7568430112' ),
                       ('1334603',      'Adalberto', 'Ríos',     '',          'Centro',                  'Alejandro Cervantes Delgado',  '#147',   '7568516879' ),
                       ('1221763',      'Jose',      'Miguel',   'Vázquez',   'El Rodeo',                'Azucenas',                     '#4312',  '7565922707' ),
                       ('1881654',      'Viviana',   'Lobato',   '',          'Agricola Orienta',        'General Delgado Meza',         '#4339',  '7561638669' ),
                       ('1765321',      'Eliseo',    'del Cid',  '',          'Ixtlahualtongo',          'Armadillo',                    '#2409',  '7565470750' ),
                       ('1983912',      'Mamen',     'Aliaga',   'Lobato',    'Santa Cecilia',           'Ayacahuites',                  '#1324',  '7567609364' );

INSERT INTO `usuarios` (`ClaveUsu`,     `Nombre`,        `Paterno`,    `Materno`,      `Colonia`,                 `Calle`,             `Numero`,  `Telefono`   ) VALUES
                       ('57221900126',  'Jose Manuel',   'Bautista',   'Morales',      'Vicente Guerrero',        'Emiliano Zapata',    '#11',     '7561270203'),
                       ('57221900128',  'Roberto',       'Chauteco',   'Bello',        'Barrio de San jose',      '09 Oriente',         '#1611',   '7561082039'),
                       ('57221900129',  'Brenda Lizeth', 'Garcia',     'Garcia',       'La cienega',              'S/N',                '#33',     '7561172383'),
                       ('57221000009',  'Juan Diego',    'Cantor',     'Jimon',        'Barrio de couyatepec',    'S/N',                'S/N',     '7561348232'),
                       ('57221900130',  'Geovanni',      'Melchor',    'Solano',       'Barrio  El Tecolote',     '13 sur',             '#516',    '7561264852'),
                       ('57221900171',  'Francisco',     'Ramirez',    'Martinez',     'Emiliano Zapata',         'campesino',          '#06',     '7561176148'),
                       ('57221900133',  'Marcos',        'Sanchez',    'del Carmen',   'San Jose',                '18 sur',             'S/N',     '7561197222'),
                       ('57221900124',  'Ángel',         'Abundes',    'Arteaga',      'Santa Cruz',              'calle 11 oriente',   'S/N',     '7561223678'),
                       ('57211000099',  'Miguel Angel',  'Morales',    'Esteban',      'Xulchuchio',              'S/C',                 'S/N',    '7561291886'),                       
                       ('57221900132',  'Saul',          'Nava',        'Luciano',     'Los Sauces',              '10 norte',            '#403',   '7561075555');


  INSERT INTO `editoriales` (`Id`,  `Nombre`                    )  VALUES
                            ( 3,    'Rc Libros'                 ),
                            ( 4,    'Marcombo'                  ),
                            ( 5,    'Ecoe Editiones'            ),
                            ( 6,    'Manning Publications'      ),
                            ( 7,    'Wiley'                     ),
                            ( 8,    'Elluminet Press'           ),
                            ( 9,    'Ediciones De La U '        ),
                            ( 10,   'XYZ Textbooks'            ),
                            ( 11,   'CIPD - Kogan Page'        ),
                            ( 12,   'Patria'                   );

 INSERT INTO `libros`    (`ISBN`,              `Titulo`,                                            `editorial_Id`) VALUES
                          ('9786075387727',     'php 8. curso practico de formacion',               3),
                          ('9786075385334',     'arduino. internet de las cosas',                   3),
                          ('9786075380896',     'aprende a programar con python',                   3),
                          ('9786075388496',     'aprende a programar con kotlin',                   3),
                          ('9786076229491',     'java desde cero y preparate para tu entrevista',   3),
                          ('9788426732446',     'guía práctica de kubernetes.',                     4),
                          ('9788426729255',     'Python Deep Learning',                             4),
                          ('9788426730688',     'Algoritmos Genéticos con Python',                  4),
                          ('9788426728661',     'Django 2',                                         4),
                          ('9789585033573',     'Ciencia de los datos con Python - 1ra edición',    4),
                          ('9789586487627',     'Redes locales nivel básico',                       4),
                          ('9789587715712',     'Bases de datos en SQL Server',                     4),
                          ('9781449281328',     'Programación orientada a objetos usamdo JAVA',     4),
                          ('9781617292071',     'jQuery in Action, Third Edition',                  6),
                          ('9781617293726',     'Kubernetes in Action',                             6),
                          ('9781617294747',     'Get Programming with Node.js',                     6),
                          ('9781617294938',     'Linux in Action',                                  6),
                          ('9781935182047',     'SQL Server MVP Deep Dives',                        6),
                          ('9781119722359',     'Ubuntu Linux Bible',                               7),
                          ('9781118087459',     'Data Mining Techniques',                           7),
                          ('9781119817406',     'Job Ready Python',                                  7),
                          ('9781118717356',     'Android Programming',                               7),
                          ('9781118725269',     'Pattern-Oriented Software Architecture',            7);



INSERT INTO `libros`    (`ISBN`,              `Titulo`,                                                     `editorial_Id`) VALUES
                          ('9781913151171',     'Python for Beginners',                                     8),
                          ('9781913151737',     'Exploring Computer Hardware',                              8),
                          ('9781913151706',     'HTML& CSS for Beginners',                                  8),
                          ('9789587627657',     'C++ Soporte Con Qt ',                                      9),
                          ('9789587415575',     'diseño y construccion de algoritmos',                      9),
                          ('9789587624717',     'laboratorio de circuitos electronicos 1',                  9),
                          ('9789587626551',     'laboratorio de circuitos electronicos ii. practica',      9),
                          ('9781630983673',     'Elementary and Intermediate Algebra',                      10),
                          ('9781630983666',     'College Algebra',                                          10),
                          ('9781630984045',     'Basic Mathematics with Early Integers',                    10),
                          ('9781630983642',     'Trigonometry',                                             10),
                          ('9781843984375',     'Leading, Managing and Developing People',                  11),
                          ('9789586483088',     'Lógica de programación - 2da Edición',                     12),
                          ('9789587711370',     'Lógica de programación orientada a objetos',               12),
                          ('9789587718263',     'Estadística descriptiva y probabilidad',                   12),
                          ('9789587920871',     'laboratorio de circuitos electrónicos i.',                 9),
                          ('9786077440383',     'circuitos electricos. teoria y practica',                  5),
                          ('9786075508177',     'física 1',                                                 5);

                    
  INSERT INTO  `autores` (`Id`, `Nombre`,           `Paterno`,         `Materno`  ) VALUES
                         ( 4,   'Italo ',           'Morales',          'F' ),
                         ( 5,   'Byron O.',         'Ganazhapa',        ''),
                         ( 6,   'José Dimas',       'Luján',            'Castillo' ),
                         ( 7,   'Brendan',          'Burns',            ''),
                         ( 8,   'Eddie',            'Villalba',         '' ),
                         ( 9,   'Dave',             'Strebel ',         ''),
                         ( 10,   'Lachlan',          'Evenson',          '' ),
                         ( 11,   'Jordi',            'Torres',          ''),
                         ( 12,   'Daniel',           'Gutiérrez',        '' ),
                         ( 13,   'Alejandro',        'Tapia',           ''),
                         ( 14,   'Alvaro',           'Rodríguez',        '' ),
                         ( 15,   'Antonio ',         'Mele ',            ''),
                         ( 16,   'Francisco J.',     'Toro',             'López'),
                         ( 17,   'MarÍa',            'González',        ''),   
                         ( 18,   'Luis Felipe',      'Wanumen',         'Silva'),
                         ( 19,   'Edwin',            'Rivas ',           'Trujillo'),
                         ( 20,   'Darin Jairo',      'Mosquera ',        'Palacios'),
                         ( 21,   'Héctor ',          'Flórez ',          ''),  
                         ( 22,   'Aurelio',          'De Rosa ',         ''),
                         ( 23,   'Bear',             'Bibeault ',        ''),
                         ( 24,   'Yehuda',           'Katz ',            ''),
                         ( 25,   'Marko',            'Luksa ',           ''),
                         ( 26,   'Jon',              'Wexler ',          ''),
                         ( 27,   'David',            'Clinton ',         ''),
                         ( 28,   'Greg',             'Low ',             ''),  
                         ( 29,   'Paul',             'Nielsen ',         ''),
                         ( 30,   'Kalen',            'Delaney ',         ''),
                         ( 31,   'Kimberly',         'Tripp ',           ''),
                         ( 32,   'Adam',             'Machanic ',        ''),
                         ( 33,   'Paul S.',          'Randal ',          ''),
                         ( 34,   'Christopher',      'Negus ',           ''),   
                         ( 35,   'Gordon S.',        'Linoff ',          ''),
                         ( 36,   'Michael J. A.',    'Berry ',           ''),
                         ( 37,   'Haythem',          'Balti ',           ''),  
                         ( 38,   'Kimberly A.',      'Weiss ',           ''),
                         ( 39,   'Erik',             'Hellman ',         ''),
                         ( 40,   'Frank',            'Buschmann ',       ''), 
                         ( 41,   'Regine',           'Meunier ',         ''),
                         ( 42,   'Hans',             'Rohnert ',         ''),
                         ( 43,   'Peter',            'Sommerlad ',       ''),
                         ( 44,   'Michael',          'Stal ',            ''),

                         ( 45,   'J',                'Foster ',          ''),
                         ( 46,   'Kevin',            'Wilson',           ''),
                         ( 47,   'Efrain  ',         'Oviedo ',          'Regino'),
                         ( 48,   'alfonso',          'mancilla',         'herrera'),  
                         ( 49,   'roberto',          'ebratt',           'gomez'),
                         ( 50,   'nicolas',          'reyes ',           'ayala'),
                         ( 51,   'raymundo',         'barrales',         'guadarrama'),
                         ( 52,   'Mark D.',          'Turner ',          ''),
                         ( 53,   'Charles P.',       'McKeague',         ''),
                         ( 54,   'Revathi',          'Narasimhan ',      ''),
                         ( 55,   'Gary',             'Rees ',            ''),
                         ( 56,   'Raymond',          'French ',          ''),
                         ( 57,   'José Luis',        'Calvo',            'González'),
                         ( 58,   'Andrés Mauricio',  'Grisales ',        'Aguirre'),
                         ( 59,   'victor rogelio ',  'barrales ',        'guadarrama'),
                         ( 60,   'meliton ezequiel', 'rodriguez ',       'rodriguez'),
                         ( 61,   'ernesto rodrigo',  'vazquez ',         'ceron'),
                         ( 62,   'hector',           'perez ',           'montiel');
                        




  INSERT INTO `libros_autores`  (`ISBN`,              `autor_Id`) VALUES
                                ('9786075387727',       4),
                                ('9786075385334',       5),
                                ('9786075380896',       6),
                                ('9786075388496',       6),
                                ('9786076229491',       6),

                                ('9788426732446',       7),
                                ('9788426732446',       8),
                                ('9788426732446',       9),
                                ('9788426732446',       10),

                                ('9788426729255',       11),

                                ('9788426730688',       12),
                                ('9788426730688',       13),
                                ('9788426730688',       14),

                                ('9788426728661',       15),
                                ('9789585033573',       16),
                                ('9789586487627',       17),

                                ('9789587715712',       18),
                                ('9789587715712',       19),
                                ('9789587715712',       20),

                                ('9781449281328',       21),

                                ('9781617292071',       22),
                                ('9781617292071',       23),
                                ('9781617292071',       24),

                                ('9781617293726',       25),
                                ('9781617294747',       26),
                                ('9781617294938',       27),

                                ('9781935182047',       28),
                                ('9781935182047',       29),
                                ('9781935182047',       30),
                                ('9781935182047',       31),
                                ('9781935182047',       32),
                                ('9781935182047',       33),

                                ('9781119722359',       27),
                                ('9781119722359',       34),

                                ('9781118087459',       35),
                                ('9781118087459',       36),

                                ('9781119817406',       37),
                                ('9781119817406',       38),

                                ('9781118717356',       39),

                                ('9781118725269',       40),
                                ('9781118725269',       41),
                                ('9781118725269',       42),
                                ('9781118725269',       43),
                                ('9781118725269',       44);





INSERT INTO `libros_autores`  (`ISBN`,              `autor_Id`) VALUES       
                                ('9781913151171',       45),
                                ('9781913151737',       46),
                                ('9781913151706',       45),
                                ('9789587627657',       47),

                                ('9789587415575',       48),
                                ('9789587415575',       49),

                                ('9789587624717',       50),

                                ('9789587626551',       51),

                                ('9781630983673',       52),
                                ('9781630983673',       53),

                                ('9781630983666',       54),
                                ('9781630984045',       53),
                                ('9781630983642',       53),

                                ('9781843984375',       55),
                                ('9781843984375',       56),

                                ('9789586483088',       47),
                                ('9789586483088',       57),

                                ('9789587711370',       47),
                                ('9789587718263',       58),

                                ('9789587920871',       59),
                                ('9789587920871',       51),
                                ('9789587920871',       60),

                                ('9786077440383',       59),
                                ('9786077440383',       51),
                                
                                ('9786075508177',       62);





  INSERT INTO `prestamos`  (`Salida`,      `Devolucion`,   `ClaveUsu`,   `ISBN`)     VALUES
    ('2023-03-01',  '2023-03-03',   '1889162',         '9781913151171'),
    ('2023-03-01',  '2023-03-03',   '1889162',         '9781913151737'),
    ('2023-03-02',  '2023-03-05',   '1889162',         '9781913151706'),

    ('2023-03-03',  '2023-03-04',   '1761521',         '9789587627657'),
    ('2023-03-02',  '2023-03-03',   '1761521',         '9789587415575'),
    ('2023-03-02',  '2023-03-07',   '1761521',         '9789587624717'),
    ('2023-03-05',  '2023-03-07',   '1761521',         '9789587626551'),
    ('2023-03-05',  '2023-03-07',   '1761521',         '9781630983673'),

    ('2023-03-03',  '2023-03-04',   '1851859',         '9781630983666'),
    ('2023-03-05',  '2023-03-06',   '1851859',         '9781630984045'),
    ('2023-03-05',  '2023-03-06',   '1851859',         '9781630983642'),

    ('2023-03-01',  '2023-03-03',   '1772483',         '9781843984375'),
    ('2023-03-03',  '2023-03-04',   '1772483',         '9781843984375'),
    ('2023-03-06',  '2023-03-07',   '1772483',         '9789587711370'),

    ('2023-03-01',  '2023-03-02',   '1257998',         '9789587718263'),
    ('2023-03-03',  '2023-03-05',   '1257998',         '9789587920871'),
    ('2023-03-06',  '2023-03-07',   '1257998',         '9786077440383'),

    ('2023-03-01',  '2023-03-03',   '1334603',         '9786075508177'),
    ('2023-03-01',  '2023-03-02',   '1334603',         '9781630984045'),
    ('2023-03-03',  '2023-03-05',   '1334603',         '9781843984375'),

    ('2023-03-03',  '2023-03-04',   '1221763',         '9781630983673'),
    ('2023-03-03',  '2023-03-04',   '1221763',         '9781630983666'),
    ('2023-03-07',          NULL,   '1221763',         '9781630984045'),

    ('2023-03-07',          NULL,   '1881654',         '9781630983642'),
    ('2023-03-07',          NULL,   '1881654',         '9781843984375'),
    ('2023-03-06',  '2023-03-07',   '1881654',         '9789586483088'),
    ('2023-03-03',  '2023-03-04',   '1881654',         '9789587711370'),

    ('2023-03-04',  '2023-03-05',   '1765321',         '9789587718263'),
    ('2023-03-04',  '2023-03-05',   '1765321',         '9789587920871'),

    ('2023-03-06',  '2023-03-07',   '1983912',         '9786077440383'),
    ('2023-03-07',          NULL,   '1983912',         '9786075508177'),
    ('2023-03-07',          NULL,   '1983912',         '9789587718263'),
    ('2023-03-07',          NULL,   '1983912',         '9781843984375'),
    ('2023-03-02',  '2023-03-04',   '1983912',         '9789587626551'),
    ('2023-03-02',  '2023-03-03',   '1983912',         '9789587627657'),
    ('2023-03-02',  '2023-03-03',   '1889162',         '9781630984045'),
    ('2023-03-03',  '2023-03-07',   '1889162',         '9781913151737');




   

  INSERT INTO `prestamos`  (`Salida`,      `Devolucion`,  `ClaveUsu`,           `ISBN`)     VALUES
                            ('2023-03-01',  '2023-03-05',   '57221900126',         '9786075387727'),
                            ('2023-03-02',  '2023-03-05',   '57221900126',         '9786075385334'),
                            ('2023-03-03',  '2023-03-05',   '57221900126',         '9786075380896'),
                            ('2023-03-04',  '2023-03-05',   '57221900126',         '9786075388496'),

                            ('2023-03-1',  '2023-03-3',   '57221900128',            '9786076229491'),
                            ('2023-03-1',  '2023-03-3',   '57221900128',            '9788426732446'),
                            ('2023-03-4',  '2023-03-7',   '57221900128',            '9788426729255'),
                            ('2023-03-4',  '2023-03-7',   '57221900128',            '9788426730688'),


                            ('2023-03-03',  '2023-03-05',   '57221900129',         '9788426728661'),
                            ('2023-03-04',  '2023-03-05',   '57221900129',         '9789585033573'),
                            ('2023-03-05',          NULL,   '57221900129',         '9789586487627'),

                            ('2023-03-01',  '2023-03-02',   '57221000009',         '9789587715712'),
                            ('2023-03-01',  '2023-03-04',   '57221000009',         '9781449281328'),
                            ('2023-03-07',        NULL ,   '57221000009',         '9781617292071'),

                            ('2023-03-06',         NULL,   '57221900130',         '9781617293726'),
                            ('2023-03-03',  '2023-03-04',   '57221900130',         '9781617294747'),
                            ('2023-03-02',  '2023-03-03',   '57221900130',         '9781617294938'),

                            ('2023-03-07',  '2023-03-07',   '57221900171',         '9781935182047'),
                            ('2023-03-02',  '2023-03-03',   '57221900171',         '9781119722359'),
                            ('2023-03-02',  '2023-03-05',   '57221900171',         '9781118087459'),
                            ('2023-03-05',  '2023-03-05',   '57221900171',         '9781119817406'),

                            ('2023-03-02',          NULL,   '57221900133',         '9781118717356'),
                            ('2023-03-02',  '2023-03-07',   '57221900133',         '9781118725269'),

                            ('2023-03-03',          NULL,   '57221900124',         '9781617294938'),
                            ('2023-03-03',          NULL,   '57221900124',         '9786075387727'),

                            ('2023-03-05',  '2023-03-06',   '57211000099',         '9788426732446'),
                            ('2023-03-05',  '2023-03-06',   '57211000099',         '9788426728661'),
                            ('2023-03-05',  '2023-03-06',   '57211000099',         '9788426732446'),

                            ('2023-03-01',  '2023-03-05',   '57221900132',         '9781119722359'),
                            ('2023-03-02',  '2023-03-05',   '57221900132',         '9781449281328'),
                            ('2023-03-03',  '2023-03-05',   '57221900132',         '9786075388496'),
                            ('2023-03-04',  '2023-03-05',   '57221900132',         '9789586487627'),
                            ('2023-03-05',          NULL,   '57221900132',         '9781617293726'),

                            ('2023-03-07',  '2023-03-07',   '57221900130',         '9786075385334'),
                            ('2023-03-07',  NULL,   '57221900124',     '9789586487627'),
                            ('2023-03-01',  '2023-03-03',   '57221900129',         '9789587715712'),
                            ('2023-03-02',  '2023-03-03',   '57221900132',         '9781617294747');