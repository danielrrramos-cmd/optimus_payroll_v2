import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Empleado } from '../models/models';
import { environment } from '../../environments/environment';

@Injectable({ providedIn: 'root' })
export class EmpleadoService {
  private apiUrl = `${environment.apiUrl}/empleados`;

  constructor(private http: HttpClient) {}

  getAll(): Observable<Empleado[]> {
    return this.http.get<Empleado[]>(this.apiUrl);
  }

  getOne(id: number): Observable<Empleado> {
    return this.http.get<Empleado>(`${this.apiUrl}/${id}`);
  }

  create(empleado: Partial<Empleado>): Observable<Empleado> {
    return this.http.post<Empleado>(this.apiUrl, empleado);
  }

  update(id: number, empleado: Partial<Empleado>): Observable<Empleado> {
    return this.http.put<Empleado>(`${this.apiUrl}/${id}`, empleado);
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiUrl}/${id}`);
  }
}
