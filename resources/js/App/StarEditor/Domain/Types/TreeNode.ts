export type TreeNodeType =
    | 'file'
    | 'folder';

export type TreeNode = {
    id: number,
    parent_id: number | null,
    type: TreeNodeType,
    name: string,
    text?: string,
    children?: Array<TreeNode>,
};

export type NodeClickEvent = {
    node: TreeNode
    mouseEvent: MouseEvent
}
