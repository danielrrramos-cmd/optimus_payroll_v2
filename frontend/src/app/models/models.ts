export interface Empleado {
  id: number;
  nombre: string;
  apellidos: string;
  dni: string;
  salarioBase: number;
  irpf: number;
  seguridadSocial: number;
}

export interface Nomina {
  id: number;
  empleado: {
    nombre: string;
    apellidos: string;
    dni: string;
    irpf: number;
    seguridadSocial: number;
  };
  fecha: string;
  bruto: number;
  irpfCantidad: number;
  ssCantidad: number;
  neto: number;
}

export interface LoginResponse {
  token: string;
}

export interface UserInfo {
  usuario: string;
  empresa_id: number;
  empresa_nombre: string;
  empresa_cif: string;
  empresa_direccion: string;
  empresa_telefono: string;
}
