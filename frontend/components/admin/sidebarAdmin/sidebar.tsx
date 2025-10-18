"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { Home, Users, Gift, LogOut } from "lucide-react";

export default function Sidebar() {
  const pathname = usePathname();

  return (
    <aside className="w-64 h-screen border-r flex flex-col justify-between px-6 py-8 bg-white">
      {/* Bagian atas */}
      <div>
        {/* Logo */}
        <div className="flex items-center gap-2 mb-10">
          <img src="/logo.svg" alt="logo" className="w-8 h-8" />
          <h1 className="text-xl font-semibold">
            <span className="text-black">Titipan</span>
            <span className="text-[#FF6B00]">Hati</span>
          </h1>
        </div>

        {/* Profil admin */}
        <div className="text-center mb-8">
          <div className="w-20 h-20 bg-gray-200 rounded-full mx-auto mb-3" />
          <h2 className="font-semibold">Profil Admin</h2>
          <p className="text-sm text-gray-500">profile@gmail.com</p>
        </div>

        {/* Menu navigasi */}
        <div>
          <ul className="space-y-3 text-gray-600">

            {/* Ringkasan */}
            <li>
              <Link
                href="/dashboard/admin"
                className={`flex items-center gap-2 px-3 py-2 rounded-lg transition ${
                  pathname === "/dashboard"
                    ? "bg-[#FF6B00] text-white"
                    : "hover:bg-gray-100"
                }`}
              >
                <Home className="w-4 h-4" /> Ringkasan
              </Link>
            </li>

            {/* Campaign */}
            <li>
              <Link
                href="/dashboard/admin/campaign"
                className={`flex items-center gap-2 px-3 py-2 rounded-lg transition ${
                  pathname === "/dashboard/admin/campaign"
                    ? "bg-[#FF6B00] text-white"
                    : "hover:bg-gray-100"
                }`}
              >
                <Gift className="w-4 h-4" /> Campaign
              </Link>
            </li>

            {/* Donasi */}
            <li>
              <Link
                href="/dashboard/admin/donasi"
                className={`flex items-center gap-2 px-3 py-2 rounded-lg transition ${
                  pathname === "/dashboard/admin/donasi"
                    ? "bg-[#FF6B00] text-white"
                    : "hover:bg-gray-100"
                }`}
              >
                <Users className="w-4 h-4" /> Donasi
              </Link>
            </li>
          </ul>
        </div>
      </div>

      {/* Tombol logout */}
      <button className="border border-[#FF6B00] text-[#FF6B00] rounded-full px-4 py-2 text-sm hover:bg-[#FF6B00] hover:text-white transition flex items-center justify-center gap-1">
        <LogOut className="w-4 h-4" /> Keluar Akun
      </button>
    </aside>
  );
}
