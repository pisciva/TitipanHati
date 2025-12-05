'use client'

import Link from 'next/link'
import { useRouter } from 'next/navigation'
import { UserCircle2 } from 'lucide-react'
import { useAuth } from '@/context/AuthContext'

export default function Navbar() {
    const { user, loading } = useAuth()
    const router = useRouter()

    const getFirstName = (name: string) => name.split(' ')[0]

    return (
        <nav className="fixed top-7 inset-x-20 flex justify-between items-center z-50 text-lg">
            <img src="/Logo.svg" alt="" className='w-48'/>

<div className="gap-12 flex justify-between font-medium text-xl">
  <Link href="/">Beranda</Link>
  <Link href="/campaign">Campaign</Link>
  <Link href="/cara-kerja">Cara Kerja</Link>
  <Link href="/tentang-kami">Tentang Kami</Link>
</div>


            {!loading && (
                user ? (
                    <button
                        onClick={() => router.push('/dashboard')}
                        className="flex items-center space-x-2 hover:font-semibold transition cursor-pointer"
                    >
                        <UserCircle2 className="w-5 h-5" />
                        <span>{getFirstName(user.fullName)}</span>
                    </button>
                ) : (
                    <Link href="/login" className="bg-[#FF4400] hover:bg-[#EB3F00] px-7 py-3 rounded-full text-white text-lg font-semibold">Donasi Sekarang!</Link>
                )
            )}
        </nav>
    )
}
