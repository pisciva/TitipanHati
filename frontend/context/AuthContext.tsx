'use client'

import { createContext, useContext, useEffect, useState, ReactNode } from 'react'
import axios from 'axios'

type User = {
    id: number
    fullName: string
    email: string
}

type AuthContextType = {
    user: User | null
    token: string | null
    loading: boolean
    logout: () => void
}

const AuthContext = createContext<AuthContextType>({
    user: null,
    token: null,
    loading: true,
    logout: () => { },
})

export const AuthProvider = ({ children }: { children: ReactNode }) => {
    const [user, setUser] = useState<User | null>(null)
    const [token, setToken] = useState<string | null>(null)
    const [loading, setLoading] = useState(true)

    const API_BASE_URL = 'http://localhost:8000/api'

    useEffect(() => {
        const checkLoginStatus = async () => {
            const params = new URLSearchParams(window.location.search)
            const urlToken = params.get('token')

            if (urlToken) {
                localStorage.setItem('token', urlToken)
                setToken(urlToken)
                window.history.replaceState({}, document.title, '/')
            }

            const storedToken = localStorage.getItem('token')
            if (!storedToken) {
                setLoading(false)
                return
            }

            try {
                const res = await axios.get(`${API_BASE_URL}/user`, {
                    headers: {
                        Authorization: `Bearer ${storedToken}`,
                        Accept: 'application/json',
                    },
                    withCredentials: true,
                })

                const userData = res.data.user
                    ? res.data.user
                    : res.data

                setUser({
                    id: userData.id,
                    fullName: userData.name ?? userData.fullName ?? '',
                    email: userData.email,
                })
                setToken(storedToken)
            } catch (err) {
                console.error('Token invalid atau kedaluwarsa:', err)
                localStorage.removeItem('token')
                setToken(null)
            } finally {
                setLoading(false)
            }
        }

        checkLoginStatus()
    }, [])

    const logout = async () => {
        try {
            const storedToken = localStorage.getItem('token')
            if (storedToken) {
                await axios.post(
                    `${API_BASE_URL}/logout`,
                    {},
                    {
                        headers: {
                            Authorization: `Bearer ${storedToken}`,
                            Accept: 'application/json',
                        },
                    }
                )
            }
        } catch (e) {
            console.warn('Logout error:', e)
        } finally {
            localStorage.removeItem('token')
            setToken(null)
            setUser(null)
        }
    }

    return (
        <AuthContext.Provider value={{ user, token, loading, logout }}>
            {children}
        </AuthContext.Provider>
    )
}

export const useAuth = () => useContext(AuthContext)
