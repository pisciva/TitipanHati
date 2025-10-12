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
   <nav className="fixed top-5 inset-x-20 bg-white/10 backdrop-blur-xs shadow-lg rounded-full z-50 text-lg">
    <div className="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      <div className="font-bold text-[#0054A5]">
        <Link href="/">asd</Link>
      </div>

      <div className="flex space-x-10 font-medium text-[#0054A5]">
        <Link href="/" className="hover:font-semibold transition">
          Home  
        </Link>

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
            <Link href="/login" className="hover:font-semibold transition cursor-pointer">
              Sign In
            </Link>
          )
        )}
      </div>
    </div>
  </nav>

  )
}
