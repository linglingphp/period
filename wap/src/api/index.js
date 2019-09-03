import axios from 'axios'
import qs from 'qs'

axios.interceptors.request.use(config => {
  const token = localStorage.JWT_TOKEN
  if (token) {
    config.headers.Authorization = `token ${localStorage.JWT_TOKEN}`
    config.headers.token = token
  }
  return config
}, err => {
  return Promise.reject(err)
})

axios.interceptors.response.use(function (response) {
  console.log(response)
  if (response.data.errorCode === 10005) {
    window.location.href = '#/login'
  } else {
    return response
  }
}, function (error) {
  // 对响应错误做点什么
  if (error.response.status === 401 && error.response.data.errorCode === 10004) {
    setTimeout(_ => {
      const url = location.href.indexOf('?') > -1 ? '&time=' + ((new Date()).getTime()) : '?time=' + ((new Date()).getTime())
      window.location.href = location.href + url
    }, 100)
  } else {
    return Promise.reject(error)
  }
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
  return axios.get(`/api/body/bodyDaily?date=` + data)
}

export const bodyDailyAdd = (data) => {
  return axios.post(`/api/body/bodyDaily`, qs.stringify(data))
}
