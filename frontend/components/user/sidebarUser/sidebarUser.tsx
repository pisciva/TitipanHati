'use client'

import Link from 'next/link'
import { usePathname } from 'next/navigation'
import { User, Clock, LogOut } from 'lucide-react'

export default function SidebarUser() {
  const pathname = usePathname()

  return (
    <aside className="w-[300px] border-r border-gray-200 flex flex-col items-center py-10 fixed top-0 left-0 h-full bg-white z-10">
      
      {/* Logo Titipan Hati */}
      <div className="flex items-center gap-2 mb-10">
        <img src="/logo.svg" alt="Logo" className="w-8 h-8" />
        <h1 className="text-xl font-semibold">
          <span className="text-black">Titipan</span>
          <span className="text-[#FF6B00]">Hati</span>
        </h1>
      </div>

      {/* Profil Pengguna */}
      <img
        src="/profile-placeholder.png"
        alt="Foto Profil"
        className="w-28 h-28 rounded-full bg-gray-200 mb-4"
      />
      <h2 className="text-lg font-semibold mb-1">Profil Pengguna</h2>
      <p className="text-gray-500 mb-8">profile@gmail.com</p>

      {/* Navigasi */}
      <div className="w-full px-8 space-y-5">
        <Link
          href="/dashboard/user"
          className={`flex items-center gap-3 font-medium ${
            pathname === '/dashboard/user'
              ? 'text-[#0054A5]'
              : 'text-gray-500 hover:text-[#0054A5]'
          }`}
        >
          <User className="w-5 h-5" /> Profil
        </Link>

        <Link
          href="/dashboard/user/riwayat"
          className={`flex items-center gap-3 font-medium ${
            pathname === '/dashboard/user/riwayat'
              ? 'text-[#0054A5]'
              : 'text-gray-500 hover:text-[#0054A5]'
          }`}
        >
          <Clock className="w-5 h-5" /> Riwayat
        </Link>
      </div>

      {/* Tombol Logout */}
      <div className="mt-auto w-full px-8 pb-10">
        <button className="w-full py-2 border border-[#FF4400] text-[#FF4400] rounded-full font-medium hover:bg-[#FFF2EE] transition flex items-center justify-center gap-2">
          <LogOut className="w-5 h-5" /> Keluar Akun
        </button>
      </div>
    </aside>
  )
}
