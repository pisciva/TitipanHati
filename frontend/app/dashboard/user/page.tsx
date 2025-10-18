'use client'

import SidebarUser from '@/components/user/sidebarUser/sidebarUser'
import ProfileForm from '@/components/user/profileForm/profileForm'

export default function UserProfilePage() {
  return (
    <div className="flex min-h-screen bg-white">
      <SidebarUser />
      <main className="flex-1 ml-[300px] px-16 py-24">
        <h1 className="text-2xl font-semibold mb-8">Informasi Pribadi</h1>
        <ProfileForm />
      </main>
    </div>
  )
}
