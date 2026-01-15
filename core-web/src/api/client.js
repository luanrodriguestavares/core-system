const API_BASE = import.meta.env.VITE_API_BASE || '';

export function apiClient(scope = 'app') {
  const basePath = scope === 'master' ? '/api/master' : '/api/app';

  async function request(path, options = {}) {
    const response = await fetch(`${API_BASE}${basePath}${path}`, {
      headers: {
        'Content-Type': 'application/json',
        ...(options.headers || {}),
      },
      ...options,
    });

    if (!response.ok) {
      const error = await response.json().catch(() => ({ message: 'Erro desconhecido' }));
      throw new Error(error.message || 'Erro na API');
    }

    return response.json();
  }

  return {
    get: (path) => request(path),
    post: (path, body) => request(path, { method: 'POST', body: JSON.stringify(body) }),
    put: (path, body) => request(path, { method: 'PUT', body: JSON.stringify(body) }),
  };
}
