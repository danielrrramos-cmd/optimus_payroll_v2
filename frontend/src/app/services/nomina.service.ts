import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Nomina } from '../models/models';
import { environment } from '../../environments/environment';

@Injectable({ providedIn: 'root' })
export class NominaService {
  private apiUrl = `${environment.apiUrl}/nominas`;

  constructor(private http: HttpClient) {}

  getAll(): Observable<Nomina[]> {
    return this.http.get<Nomina[]>(this.apiUrl);
  }

  getOne(id: number): Observable<Nomina> {
    return this.http.get<Nomina>(`${this.apiUrl}/${id}`);
  }

  generar(empleadoId: number, mes: number, anio: number): Observable<Nomina> {
    return this.http.post<Nomina>(`${this.apiUrl}/generar`, {
      empleado_id: empleadoId,
      mes,
      anio
    });
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiUrl}/${id}`);
  }
}
