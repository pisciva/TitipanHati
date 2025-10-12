'use client'

import { Eye, EyeOff } from 'lucide-react'
import React from 'react'
import '@/app/globals.css'

type InputFieldProps = {
    label?: string
    type?: string
    placeholder?: string
    icon?: string
    maxLength?: number
    showPasswordToggle?: boolean
    showPassword?: boolean
    setShowPassword?: (v: boolean) => void
    error?: string
    register: any
    name: string
    rules?: object
}

export const InputField = ({
    label,
    type = 'text',
    placeholder,
    icon,
    maxLength,
    showPasswordToggle = false,
    showPassword,
    setShowPassword,
    error,
    register,
    name,
    rules,
}: InputFieldProps) => {
    return (
        <div className="mt-4">
            <div className='text-[#FF0000] font-semibold text-lg mb-1'>{label}</div> 

            <div className="relative">
                {icon && <img src={icon} className="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 lg:w-6.5 lg:h-6.5" />}

                <input
                    type={type === 'password' && showPasswordToggle ? showPassword ? 'text' : 'password' : type}
                    maxLength={maxLength}
                    placeholder={placeholder}
                    {...register(name, rules)}
                    className={`w-full h-12 lg:h-14 pl-14 pr-4 input-base ${error ? 'input-error' : 'input-base'}`} />

                {showPasswordToggle && setShowPassword && (
                    <span onClick={() => setShowPassword(!showPassword)}
                        className="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-[#64748B]">
                        {showPassword ? <EyeOff size={20} /> : <Eye size={20} />}
                    </span>
                )}
            </div>

            <div className="mt-1">
                {error && <p className="text-[#EF4444] text-sm">{error}</p>}
            </div>
        </div>
    )
}
