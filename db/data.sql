USE library;

INSERT INTO author (name) VALUES
('Machado de Assis'),
('Clarice Lispector'),
('Jorge Amado'),
('Graciliano Ramos'),
('Cecília Meireles');

INSERT INTO book (author_id, isbn, title, year, era, location) VALUES
(1, '9788535902776', 'Dom Casmurro', 1899, 'AD', 'A-01'),
(1, '9788535914849', 'Memórias Póstumas de Brás Cubas', 1881, 'AD', 'A-01'),
(2, '9788532530783', 'A Hora da Estrela', 1977, 'AD', 'A-02'),
(2, '9788520926104', 'Perto do Coração Selvagem', 1943, 'AD', 'A-02'),
(3, '9788535911695', 'Capitães da Areia', 1937, 'AD', 'A-03'),
(3, '9788535911657', 'Gabriela, Cravo e Canela', 1958, 'AD', 'A-03'),
(4, '9788501012203', 'Vidas Secas', 1938, 'AD', 'A-04'),
(4, '9788501012227', 'São Bernardo', 1934, 'AD', 'A-04'),
(5, '9788526016571', 'Romanceiro da Inconfidência', 1953, 'AD', 'A-05'),
(5, '9788526016564', 'Viagem', 1939, 'AD', 'A-05');