INSERT INTO empresas (nombre, cif, direccion, telefono) VALUES ('Optimus Corp', 'B12345678', 'Calle Principal 123', '912345678');
INSERT INTO usuarios (usuario, password, empresa_id) VALUES ('admin', '$2y$10$yUyxR3xbb9fecRRAC03QPeWRXtRSu/OpBrPLWHvvGj69jALV1icTq', 1);
SELECT id, usuario, empresa_id FROM usuarios;
