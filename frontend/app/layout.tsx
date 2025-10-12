'use client'

import { ReactNode, useEffect } from 'react'
import { usePathname } from 'next/navigation'
import { Plus_Jakarta_Sans } from 'next/font/google'
import { AuthProvider } from '@/context/AuthContext'
import Navbar from '@/components/layouts/Navbar'
import '@/app/globals.css'

const font = Plus_Jakarta_Sans({
    subsets: ['latin'],
    variable: '--font-plusjakarta',
})

export default function RootLayout({ children }: { children: ReactNode }) {
    const pathname = usePathname()

    useEffect(() => {
        const urlParams = new URLSearchParams(window.location.search)
        const token = urlParams.get('token')

        if (token) {
            localStorage.setItem('token', token)
            const newUrl = window.location.pathname
            window.history.replaceState({}, '', newUrl)
            window.location.reload()
        }
    }, [])

    const noNavbarRoutes = ['/login', '/register', '/forgot-password', '/reset-password']
    const hideNavbar = noNavbarRoutes.includes(pathname)

    return (
        <html lang="en" className={font.className}>
            <body className="min-h-screen w-full bg-gradient-to-b from-[#A0CAE8] to-[#F8FAFC] bg-svg">
                <AuthProvider>
                    {!hideNavbar && <Navbar />}
                    {children}
                </AuthProvider>
            </body>
        </html>
    )
}
