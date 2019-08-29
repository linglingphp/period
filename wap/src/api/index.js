import axios from 'axios'
import qs from 'qs'

axios.interceptors.request.use(config => {
  const token = localStorage.JWT_TOKEN
  console.log(token)
  console.log('--------------')
  if (token) {
    config.headers.Authorization = `token ${localStorage.JWT_TOKEN}`
    config.headers.token = token
  }
  return config
}, err => {
  return Promise.reject(err)
})

// 换取token
export const auths = (data) => {
  return axios.post(`/api/auth`, qs.stringify(data))
}

// 检查token是否过期
export const checkLogin = (data) => {
  return axios.get(`/api/checkStatus`, {
    params: data
  })
}

export const memberGet = (data) => {
  return axios.get(`/api/member`)
}

export const memberUpdate = (data) => {
  return axios.post(`/api/member`, qs.stringify(data))
}

export const bodyDailyList = (data) => {
  return axios.get(`/api/body/bodyDailys`)
}

export const bodyDailyGet = (data) => {
  return axios.get(`/api/body/bodyDaily`)
}

export const bodyDailyAdd = (data) => {
  return axios.post(`/api/body/bodyDaily`, qs.stringify(data))
}
