import type { TreeNode } from '../Types/TreeNode'

export const mockTree: TreeNode[] = [
    {
        id: 1,
        parent_id: null,
        type: 'folder',
        name: 'База знаний',
        children: [
            {
                id: 2,
                parent_id: 1,
                type: 'folder',
                name: 'Программирование',
                children: [
                    {
                        id: 3,
                        parent_id: 2,
                        type: 'folder',
                        name: 'Vue & Frontend',
                        children: [
                            {
                                id: 31,
                                parent_id: 3,
                                type: 'file',
                                name: 'Vue 3 шпаргалка',
                                text: '# Vue 3\n\nComposition API, script setup, reactivity...',
                            },
                            {
                                id: 32,
                                parent_id: 3,
                                type: 'file',
                                name: 'Tailwind паттерны',
                                text: '# Tailwind\n\nПолезные утилиты и трюки...',
                            },
                        ],
                    },
                    {
                        id: 4,
                        parent_id: 2,
                        type: 'file',
                        name: 'TypeScript советы',
                        text: '# TypeScript\n\nПолезные паттерны для джунов...',
                    },
                    {
                        id: 5,
                        parent_id: 2,
                        type: 'file',
                        name: 'Laravel + Eloquent',
                        text: '# Laravel\n\nОтношения, миграции, unsignedBigInteger...',
                    },

                ],
            },
            {
                id: 6,
                parent_id: 1,
                type: 'folder',
                name: 'Философия',
                children: [
                    {
                        id: 61,
                        parent_id: 6,
                        type: 'file',
                        name: 'Гёдель и неполнота',
                        text: '# Теорема Гёделя\n\nЛюбая система замыкается извне...',
                    },
                    {
                        id: 62,
                        parent_id: 6,
                        type: 'file',
                        name: 'Гештальт и целое',
                        text: '# Гештальт\n\nЦелое больше суммы частей...',
                    },
                ],
            },
        ],
    },
    {
        id: 10,
        parent_id: null,
        type: 'folder',
        name: 'Проекты',
        children: [
            {
                id: 11,
                parent_id: 10,
                type: 'file',
                name: 'Obsidian Clone — роадмап',
                text: '# Obsidian Clone\n\n## Этапы\n- [ ] Tree view\n- [ ] Markdown editor\n- [ ] Graph view',
            },
            {
                id: 12,
                parent_id: 10,
                type: 'file',
                name: 'Архитектура хранилища',
                text: '# Архитектура\n\nLocalStorage → IndexedDB → Backend...',
            },
        ],
    },
    {
        id: 20,
        parent_id: null,
        type: 'file',
        name: 'Добро пожаловать',
        text: '# Добро пожаловать!\n\nЭто стартовая заметка.',
    },
    {
        id: 21,
        parent_id: null,
        type: 'file',
        name: 'Быстрые мысли',
        text: 'Идеи которые надо развить позже...',
    },
]
