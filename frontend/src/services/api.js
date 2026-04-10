import axios from "axios";



const api = axios.create({
  baseURL: "http://127.0.0.1:8000/api/v1"
});

//  TOKEN
api.interceptors.request.use(config => {
  const token = localStorage.getItem("token");

  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }

  return config;
});

//  GLOBAL 401 HANDLER
api.interceptors.response.use(
  response => response,
  error => {

    const isLoginRequest = error.config?.url?.includes("/login");

    //  NON REDIRECTARE SE È LOGIN
    if (error.response?.status === 401 && !isLoginRequest) {

      localStorage.removeItem("token");
      window.location.href = "/login";
    }

    return Promise.reject(error);
  }
);

export default api;



