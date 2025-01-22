import { User } from '@/types';
import { Link, router } from '@inertiajs/react';
import { ActionIcon, Menu } from '@mantine/core';
import { CiUser } from 'react-icons/ci';

export default function TopNav({ user }: { user: User }) {
    return (
        <>
            <div className="pr-4">
                <Menu shadow="md" width={200}>
                    <Menu.Target>
                        <ActionIcon variant="outline" size="xl" radius="xl">
                            <CiUser style={{ width: '60%', height: '60%' }} />
                        </ActionIcon>
                    </Menu.Target>
                    <Menu.Dropdown>
                        <Menu.Label>
                            {user.profile.first_name} {user.profile.last_name}
                        </Menu.Label>
                        <Menu.Item>
                            <Link
                                href={route('profile.edit')}
                                className="block h-full w-full"
                            >
                                Profile
                            </Link>
                        </Menu.Item>
                        <Menu.Item>
                            <Link
                                href={route('security.edit')}
                                className="block h-full w-full"
                            >
                                Security
                            </Link>
                        </Menu.Item>
                        <Menu.Divider />
                        <Menu.Item
                            color="red"
                            onClick={() => router.post(route('logout'))}
                        >
                            Logout
                        </Menu.Item>
                    </Menu.Dropdown>
                </Menu>
            </div>
        </>
    );
}
